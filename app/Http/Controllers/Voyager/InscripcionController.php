<?php

namespace App\Http\Controllers\Voyager;

use App\Models\EventoDetalleModalidadesArma;
use App\Models\Inscripcion;
use App\Models\TipoCategoria;
use App\Models\ValorModalidadesPorTipoArma;
use App\Notifications\InscripcionRecibida;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Events\BreadDataAdded;
use App\Mail\inscripcion_recibida;
use App\Mail\InscripcionAdminRecibidaMail;
use App\Mail\InscripcionRecibidaMail;
use App\Models\Arma;
use App\Models\DetalleInscripcion;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataRestored;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;


class InscripcionController extends VoyagerBaseController
{
    public function detalle($id)
    {
        try {
            $detalles = DetalleInscripcion::where('codigo_inscripcion', $id)->get();
    
            if ($detalles->isEmpty()) {
                return response()->json(['error' => 'No se encontraron detalles para esta inscripción.'], 404);
            }
    
            // Prepara los detalles para la respuesta JSON
            $detalleData = $detalles->map(function ($detalle) {
                // Obtener usuario
                $usuario = User::find($detalle->user_id);
                $usuarioNombre = $usuario ? $usuario->primer_nombre . ' ' . $usuario->segundo_nombre . ' ' . $usuario->primer_apellido . ' ' . $usuario->segundo_apellido : __('voyager::generic.none');
    
                // Obtener detalle del evento
                $eventoDetalle = EventoDetalleModalidadesArma::find($detalle->codigo_evento_detalle);
                $eventoDetalleInfo = $eventoDetalle ? $eventoDetalle->evento->nombre_evento . ' - ' . $eventoDetalle->tipoArma->arma . ' - ' . $eventoDetalle->tipoModalidadArma->modalidad . ' - ' . $eventoDetalle->horario . ' - ' . $eventoDetalle->lugar : __('voyager::generic.none');
    
                // Obtener información de armas
                $armasInfo = [];
                $tipoArmasIds = json_decode($detalle->codigo_arma);
                if ($tipoArmasIds) {
                    foreach ($tipoArmasIds as $armaId) {
                        $arma = Arma::find($armaId);
                        if ($arma) {
                            $armasInfo[] = $arma->metodoPropulsion->metodo_propulsion . ' - ' . $arma->numero_serie . ' - ' . $arma->tipoArma->arma . ' - ' . $arma->calibre->nombre_comun . ' - ' . $arma->tipoPropiedad->tipo_propiedad;
                        }
                    }
                }
    
                return [
                    'codigo_inscripcion' => $detalle->codigo_inscripcion,
                    'documento_tercero' => $detalle->documento_tercero ?: __('voyager::generic.none'),
                    'usuario' => $usuarioNombre,
                    'eventoDetalle' => $eventoDetalleInfo,
                    'armas' => $armasInfo,
                    'puntaje' => $detalle->puntaje ?: __('voyager::generic.none'),
                    'observaciones' => $detalle->observaciones ?: __('voyager::generic.none'),
                ];
            });
    
            return response()->json(['detalles' => $detalleData]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudieron cargar los detalles de la inscripción.'], 500);
        }
    }
    
    public function getValorInscripcion(Request $request)
    {
        // Obtener los datos del request
        $modalidadesSeleccionadas = $request->input('modalidades_seleccionadas');
        $codigoTipoCategoria = $request->input('codigo_tipo_categoria');

        // Obtener el código de tipo de arma desde evento_detalle_modalidades_armas
        $codigoTipoArma = null;
        if (!empty($modalidadesSeleccionadas)) {
            $eventoDetalleModalidadArma = EventoDetalleModalidadesArma::find($modalidadesSeleccionadas[0]);
            if ($eventoDetalleModalidadArma) {
                $codigoTipoArma = $eventoDetalleModalidadArma->codigo_tipo_arma;
            }
        }

        // Consultar los valores por cantidad de modalidades desde la base de datos
        $valoresPorModalidades = ValorModalidadesPorTipoArma::where('codigo_tipo_arma', $codigoTipoArma)
            ->where('codigo_tipo_categoria', $codigoTipoCategoria)
            ->first();

        if (!$valoresPorModalidades) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron valores para las modalidades seleccionadas y la categoría especificada.',
            ]);
        }

        // Calcular el valor de la inscripción basado en las modalidades seleccionadas

        $cantidadModalidades = count($modalidadesSeleccionadas);
        // Mapeo de cantidad de modalidades a nombres de campos
        $camposValor = [
            1 => 'valor_una_modalidad',
            2 => 'valor_dos_modalidades',
            3 => 'valor_tres_modalidades',
            4 => 'valor_cuatro_modalidades',
            5 => 'valor_cinco_modalidades',
            6 => 'valor_seis_modalidades',
            //Si se necesitan mas valores se agregan aqui como por ejemplo 'valor_siete_modalidades', etc.
        ];

        // Verificar si la cantidad de modalidades está en el mapeo
        if (isset($camposValor[$cantidadModalidades])) {
            $campoValor = $camposValor[$cantidadModalidades];
            // Verificar que el campo exista en el modelo antes de acceder a él
            if (isset($valoresPorModalidades->$campoValor)) {
                $valor = $valoresPorModalidades->$campoValor;
            }
        } else {
            // Manejar caso donde la cantidad de modalidades no está en el mapeo
            return response()->json([
                'success' => false,
                'message' => 'No se encontró un campo correspondiente para la cantidad de modalidades seleccionadas.',
            ]);
        }
        return response()->json([
            'success' => true,
            'valor' => $valor,
        ]);
    }

    public function store(Request $request)
    {
        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
        $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

        event(new BreadDataAdded($dataType, $data));

        // Datos del usuario autenticado
        $user = Auth::user();

        $validated = $request->validate([
            'codigo_evento' => 'required|integer',
            'codigo_tipo_categoria' => 'required|integer',
            'acepta_politicas' => 'required|string',
            'valor' => 'required|numeric',
            'comprobante_pago' => 'required|string',
            'codigo_tipo_arma_evento' => 'required|array',
            'codigo_tipo_arma_evento.*' => 'required|integer',
            'codigo_arma' => 'required|array',
            'codigo_arma.*' => 'required|integer',
            'consentimiento_padres' => 'nullable|file',
            'pdf_comprobante_pago' => 'nullable|file',
            'pdf_permiso_porte' => 'nullable|file',
            'codigo_tipo_estado_inscripcion' => 'nullable|integer',
            'fecha_validacion_federacion' => 'nullable|date',
            'observaciones' => 'nullable|string',
        ]);


        try {
            DB::beginTransaction();

            // Verificar si ya existe una inscripción para el usuario y el evento
            $existingInscripcion = Inscripcion::where('user_id', $user->id)
                ->where('codigo_evento', $request->codigo_evento)
                ->first();

            if ($existingInscripcion) {
                // Si ya existe, usar el registro existente
                $inscripcion = $existingInscripcion;
            } else {
                // Crear nuevo registro en la tabla inscripcion
                $inscripcion = Inscripcion::create([
                    'user_id' => $user->id,
                    'documento_tercero' => $user->username, // Suponiendo que username es el documento
                    'codigo_evento' => $request->codigo_evento,
                    'codigo_tipo_categoria' => $request->codigo_tipo_categoria,
                    'acepta_politicas' => $request->acepta_politicas === 'SI' ? 'SI' : 'NO', // Guardar como "SI" o "NO"
                    'valor' => $request->valor,
                    'comprobante_pago' => $request->comprobante_pago,
                    'codigo_tipo_estado_inscripcion' => $request->codigo_tipo_estado_inscripcion ?? null,
                    'fecha_validacion_federacion' => $request->fecha_validacion_federacion ?? null,
                    'observaciones' => $request->observaciones ?? null,
                    'pdf_comprobante_pago' => $request->pdf_comprobante_pago ? $request->pdf_comprobante_pago->store('inscripcion') : null,
                    'pdf_permiso_porte' => $request->pdf_permiso_porte ? $request->pdf_permiso_porte->store('inscripcion') : null,
                    'consentimiento_padres' => $request->consentimiento_padres ? $request->consentimiento_padres->store('inscripcion') : null,
                ]);
            }

            // Crear registros en la tabla detalle_inscripcion
            foreach ($request->codigo_tipo_arma_evento as $key => $codigo_evento_detalle) {
                DetalleInscripcion::create([
                    'user_id' => $user->id,
                    'documento_tercero' => $user->username, // Suponiendo que username es el documento
                    'codigo_inscripcion' => $inscripcion->codigo_inscripcion,
                    'codigo_evento_detalle' => $codigo_evento_detalle,
                    'codigo_arma' => $request->codigo_arma ? json_encode($request->codigo_arma) : null, // Guardar como JSON si hay múltiples valores
                    'puntaje' => null,
                    'observaciones' => null,
                ]);
            }

            DB::commit();

            // // Enviar el correo al usuario
            // Mail::to('deseosecreto92@gmail.com')->send(new InscripcionAdminRecibidaMail($inscripcion, $user));
            // Mail::to($user->email)->send(new InscripcionRecibidaMail($inscripcion, $user));

            // Obtener el correo desde las configuraciones de Voyager
            $adminEmail = Voyager::setting('admin.correo', 'deseosecreto92@gmail.com');

            // Enviar el correo al usuario
            Mail::to($adminEmail)->send(new InscripcionAdminRecibidaMail($inscripcion, $user));
            Mail::to($user->email)->send(new InscripcionRecibidaMail($inscripcion, $user));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la inscripción: ' . $e->getMessage());

            return back()->with([
                'message'    => __('voyager::generic.error_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'danger',
            ]);
        }

        // Redireccionar después de guardar la inscripción
        if (!$request->has('_tagging')) {
            if (auth()->user()->can('browse', $data)) {
                $redirect = redirect()->route("voyager.{$dataType->slug}.index");
            } else {
                $redirect = redirect()->back();
            }

            return $redirect->with([
                'message'    => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
                'alert-type' => 'success',
            ]);
        } else {
            return response()->json(['success' => true, 'data' => $data]);
        }
    }

    // public function store(Request $request)
    // {
    //     $slug = $this->getSlug($request);
    //     $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

    //     // Check permission
    //     $this->authorize('add', app($dataType->model_name));

    //     // Validate fields with ajax
    //     $val = $this->validateBread($request->all(), $dataType->addRows)->validate();

    //     // Prepare data for insertion
    //     $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

    //     // Asegurarse de que los arrays están en formato JSON
    //     if (isset($data['codigo_tipo_arma_evento']) && is_array($data['codigo_tipo_arma_evento'])) {
    //         $data['codigo_tipo_arma_evento'] = json_encode($data['codigo_tipo_arma_evento']);
    //     }
    //     if (isset($data['codigo_arma']) && is_array($data['codigo_arma'])) {
    //         $data['codigo_arma'] = json_encode($data['codigo_arma']);
    //     }

    //     // Crear una nueva inscripción
    //     $inscripcion = new Inscripcion();
    //     $inscripcion->codigo_evento = $data['codigo_evento'];
    //     $inscripcion->codigo_tipo_categoria = $data['codigo_tipo_categoria'];
    //     $inscripcion->codigo_tipo_arma_evento = $data['codigo_tipo_arma_evento'];
    //     $inscripcion->acepta_politicas = $data['acepta_politicas'];
    //     $inscripcion->codigo_arma = $data['codigo_arma'];
    //     $inscripcion->valor = $data['valor'];
    //     $inscripcion->observaciones = $data['observaciones'];

    //     // El campo `documento_tercero`, `user_id` y `categoria` se establece automáticamente en el modelo

    //     // Guardar la inscripción
    //     $inscripcion->save();

    //     // Enviar la notificación al usuario
    //     $usuario = $request->user();
    //     try {
    //         $usuario->notify(new InscripcionRecibida($inscripcion, $usuario));
    //     } catch (\Exception $e) {
    //         return back()->with([
    //             'message'    => __('voyager::generic.error_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
    //             'alert-type' => 'danger',
    //         ]);
    //     }

    //     // Redireccionar después de guardar la inscripción
    //     if (!$request->has('_tagging')) {
    //         if (auth()->user()->can('browse', $data)) {
    //             $redirect = redirect()->route("voyager.{$dataType->slug}.index");
    //         } else {
    //             $redirect = redirect()->back();
    //         }

    //         return $redirect->with([
    //             'message'    => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
    //             'alert-type' => 'success',
    //         ]);
    //     } else {
    //         return response()->json(['success' => true, 'data' => $data]);
    //     }
    // }



    public function index(Request $request)
    {
        // GET THE SLUG, ex. 'posts', 'pages', etc.
        $slug = $this->getSlug($request);

        // GET THE DataType based on the slug
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('browse', app($dataType->model_name));

        $getter = $dataType->server_side ? 'paginate' : 'get';

        $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];

        $searchNames = [];
        if ($dataType->server_side) {
            $searchNames = $dataType->browseRows->mapWithKeys(function ($row) {
                return [$row['field'] => $row->getTranslatedAttribute('display_name')];
            });
        }

        $orderBy = $request->get('order_by', $dataType->order_column);
        $sortOrder = $request->get('sort_order', $dataType->order_direction);
        $usesSoftDeletes = false;
        $showSoftDeleted = false;

        // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            $query = $model::select($dataType->name . '.*');

            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query->{$dataType->scope}();
            }

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model)) && Auth::user()->can('delete', app($dataType->model_name))) {
                $usesSoftDeletes = true;

                if ($request->get('showSoftDeleted')) {
                    $showSoftDeleted = true;
                    $query = $query->withTrashed();
                }
            }

            // If a column has a relationship associated with it, we do not want to show that field
            $this->removeRelationshipField($dataType, 'browse');

            if ($search->value != '' && $search->key && $search->filter) {
                $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
                $search_value = ($search->filter == 'equals') ? $search->value : '%' . $search->value . '%';

                $searchField = $dataType->name . '.' . $search->key;
                if ($row = $this->findSearchableRelationshipRow($dataType->rows->where('type', 'relationship'), $search->key)) {
                    $query->whereIn(
                        $searchField,
                        $row->details->model::where($row->details->label, $search_filter, $search_value)->pluck('id')->toArray()
                    );
                } else {
                    if ($dataType->browseRows->pluck('field')->contains($search->key)) {
                        $query->where($searchField, $search_filter, $search_value);
                    }
                }
            }

            $row = $dataType->rows->where('field', $orderBy)->firstWhere('type', 'relationship');
            if ($orderBy && (in_array($orderBy, $dataType->fields()) || !empty($row))) {
                $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
                if (!empty($row)) {
                    $query->select([
                        $dataType->name . '.*',
                        'joined.' . $row->details->label . ' as ' . $orderBy,
                    ])->leftJoin(
                        $row->details->table . ' as joined',
                        $dataType->name . '.' . $row->details->column,
                        'joined.' . $row->details->key
                    );
                }

                $dataTypeContent = call_user_func([
                    $query->orderBy($orderBy, $querySortOrder),
                    $getter,
                ]);
            } elseif ($model->timestamps) {
                $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
            } else {
                $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
            }

            // Replace relationships' keys for labels and create READ links if a slug is provided.
            $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
        } else {
            // If Model doesn't exist, get data from table name
            $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
            $model = false;
        }

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($model);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'browse', $isModelTranslatable);

        // Check if server side pagination is enabled
        $isServerSide = isset($dataType->server_side) && $dataType->server_side;

        // Check if a default search key is set
        $defaultSearchKey = $dataType->default_search_key ?? null;

        // Actions
        $actions = [];
        if (!empty($dataTypeContent->first())) {
            foreach (Voyager::actions() as $action) {
                $action = new $action($dataType, $dataTypeContent->first());

                if ($action->shouldActionDisplayOnDataType()) {
                    $actions[] = $action;
                }
            }
        }

        // Define showCheckboxColumn
        $showCheckboxColumn = false;
        if (Auth::user()->can('delete', app($dataType->model_name))) {
            $showCheckboxColumn = true;
        } else {
            foreach ($actions as $action) {
                if (method_exists($action, 'massAction')) {
                    $showCheckboxColumn = true;
                }
            }
        }

        // Define orderColumn
        $orderColumn = [];
        if ($orderBy) {
            $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + ($showCheckboxColumn ? 1 : 0);
            $orderColumn = [[$index, $sortOrder ?? 'desc']];
        }

        // Define list of columns that can be sorted server side
        $sortableColumns = $this->getSortableColumns($dataType->browseRows);

        $view = 'voyager::bread.browse';

        if (view()->exists("voyager::$slug.browse")) {
            $view = "voyager::$slug.browse";
        }

        return Voyager::view($view, compact(
            'actions',
            'dataType',
            'dataTypeContent',
            'isModelTranslatable',
            'search',
            'orderBy',
            'orderColumn',
            'sortableColumns',
            'sortOrder',
            'searchNames',
            'isServerSide',
            'defaultSearchKey',
            'usesSoftDeletes',
            'showSoftDeleted',
            'showCheckboxColumn'
        ));
    }

    //***************************************
    //                _____
    //               |  __ \
    //               | |__) |
    //               |  _  /
    //               | | \ \
    //               |_|  \_\
    //
    //  Read an item of our Data Type B(R)EAD
    //
    //****************************************

    public function show(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $isSoftDeleted = false;

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $query = $model->query();

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $query = $query->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query = $query->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$query, 'findOrFail'], $id);
            if ($dataTypeContent->deleted_at) {
                $isSoftDeleted = true;
            }
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        // Replace relationships' keys for labels and create READ links if a slug is provided.
        $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'read');

        // Check permission
        $this->authorize('read', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'read', $isModelTranslatable);

        $view = 'voyager::bread.read';

        if (view()->exists("voyager::$slug.read")) {
            $view = "voyager::$slug.read";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'isSoftDeleted'));
    }

    //***************************************
    //                ______
    //               |  ____|
    //               | |__
    //               |  __|
    //               | |____
    //               |______|
    //
    //  Edit an item of our Data Type BR(E)AD
    //
    //****************************************

    public function edit(Request $request, $id)
    {

        $user = Auth::user();
        $fechaNacimiento = Carbon::parse($user->fecha_nacimiento);
        $edad = $fechaNacimiento->age;

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);
            $query = $model->query();

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $query = $query->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $query = $query->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$query, 'findOrFail'], $id);
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        foreach ($dataType->editRows as $key => $row) {
            $dataType->editRows[$key]['col_width'] = isset($row->details->width) ? $row->details->width : 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'edit');

        // Check permission
        $this->authorize('edit', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'edit', $isModelTranslatable);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }

        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'edad'));
    }

    // POST BR(E)AD
    public function update(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Compatibility with Model binding.
        $id = $id instanceof \Illuminate\Database\Eloquent\Model ? $id->{$id->getKeyName()} : $id;

        $model = app($dataType->model_name);
        $query = $model->query();
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $query = $query->{$dataType->scope}();
        }
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $query = $query->withTrashed();
        }

        $data = $query->findOrFail($id);

        // Check permission
        $this->authorize('edit', $data);

        // Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->editRows, $dataType->name, $id)->validate();

        // Get fields with images to remove before updating and make a copy of $data
        $to_remove = $dataType->editRows->where('type', 'image')
            ->filter(function ($item, $key) use ($request) {
                return $request->hasFile($item->field);
            });
        $original_data = clone ($data);

        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        // Delete Images
        $this->deleteBreadImages($original_data, $to_remove);

        event(new BreadDataUpdated($dataType, $data));

        if (auth()->user()->can('browse', app($dataType->model_name))) {
            $redirect = redirect()->route("voyager.{$dataType->slug}.index");
        } else {
            $redirect = redirect()->back();
        }

        return $redirect->with([
            'message'    => __('voyager::generic.successfully_updated') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
            'alert-type' => 'success',
        ]);
    }

    //***************************************
    //
    //                   /\
    //                  /  \
    //                 / /\ \
    //                / ____ \
    //               /_/    \_\
    //
    //
    // Add a new item of our Data Type BRE(A)D
    //
    //****************************************

    public function create(Request $request)
    {

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Calcular la edad del usuario a partir de su fecha de nacimiento
        $fechaNacimiento = Carbon::parse($user->fecha_nacimiento);
        $edad = $fechaNacimiento->age;

        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('add', app($dataType->model_name));

        $dataTypeContent = (strlen($dataType->model_name) != 0)
            ? new $dataType->model_name()
            : false;

        foreach ($dataType->addRows as $key => $row) {
            $dataType->addRows[$key]['col_width'] = $row->details->width ?? 100;
        }

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'add');

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'add', $isModelTranslatable);

        $view = 'voyager::bread.edit-add';

        if (view()->exists("voyager::$slug.edit-add")) {
            $view = "voyager::$slug.edit-add";
        }



        return Voyager::view($view, compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'edad'));
    }


    /**
     * POST BRE(A)D - Store data.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function store(Request $request)
    // {
    //     $slug = $this->getSlug($request);

    //     $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

    //     // Check permission
    //     $this->authorize('add', app($dataType->model_name));

    //     // Validate fields with ajax
    //     $val = $this->validateBread($request->all(), $dataType->addRows)->validate();
    //     $data = $this->insertUpdateData($request, $slug, $dataType->addRows, new $dataType->model_name());

    //     event(new BreadDataAdded($dataType, $data));

    // if (!$request->has('_tagging')) {
    //     if (auth()->user()->can('browse', $data)) {
    //         $redirect = redirect()->route("voyager.{$dataType->slug}.index");
    //     } else {
    //         $redirect = redirect()->back();
    //     }

    //     return $redirect->with([
    //         'message'    => __('voyager::generic.successfully_added_new') . " {$dataType->getTranslatedAttribute('display_name_singular')}",
    //         'alert-type' => 'success',
    //     ]);
    // } else {
    //     return response()->json(['success' => true, 'data' => $data]);
    // }
    // }

    //***************************************
    //                _____
    //               |  __ \
    //               | |  | |
    //               | |  | |
    //               | |__| |
    //               |_____/
    //
    //         Delete an item BREA(D)
    //
    //****************************************

    public function destroy(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Init array of IDs
        $ids = [];
        if (empty($id)) {
            // Bulk delete, get IDs from POST
            $ids = explode(',', $request->ids);
        } else {
            // Single item delete, get ID from URL
            $ids[] = $id;
        }

        $affected = 0;

        foreach ($ids as $id) {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

            // Check permission
            $this->authorize('delete', $data);

            $model = app($dataType->model_name);
            if (!($model && in_array(SoftDeletes::class, class_uses_recursive($model)))) {
                $this->cleanup($dataType, $data);
            }

            $res = $data->delete();

            if ($res) {
                $affected++;

                event(new BreadDataDeleted($dataType, $data));
            }
        }

        $displayName = $affected > 1 ? $dataType->getTranslatedAttribute('display_name_plural') : $dataType->getTranslatedAttribute('display_name_singular');

        $data = $affected
            ? [
                'message'    => __('voyager::generic.successfully_deleted') . " {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('voyager::generic.error_deleting') . " {$displayName}",
                'alert-type' => 'error',
            ];

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
    }

    public function restore(Request $request, $id)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $model = app($dataType->model_name);
        $this->authorize('delete', $model);

        // Get record
        $query = $model->withTrashed();
        if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
            $query = $query->{$dataType->scope}();
        }
        $data = $query->findOrFail($id);

        $displayName = $dataType->getTranslatedAttribute('display_name_singular');

        $res = $data->restore($id);
        $data = $res
            ? [
                'message'    => __('voyager::generic.successfully_restored') . " {$displayName}",
                'alert-type' => 'success',
            ]
            : [
                'message'    => __('voyager::generic.error_restoring') . " {$displayName}",
                'alert-type' => 'error',
            ];

        if ($res) {
            event(new BreadDataRestored($dataType, $data));
        }

        return redirect()->route("voyager.{$dataType->slug}.index")->with($data);
    }

    //***************************************
    //
    //  Delete uploaded file
    //
    //****************************************

    public function remove_media(Request $request)
    {
        try {
            // GET THE SLUG, ex. 'posts', 'pages', etc.
            $slug = $request->get('slug');

            // GET file name
            $filename = $request->get('filename');

            // GET record id
            $id = $request->get('id');

            // GET field name
            $field = $request->get('field');

            // GET multi value
            $multi = $request->get('multi');

            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

            // Load model and find record
            $model = app($dataType->model_name);
            $data = $model::find([$id])->first();

            // Check if field exists
            if (!isset($data->{$field})) {
                throw new Exception(__('voyager::generic.field_does_not_exist'), 400);
            }

            // Check permission
            $this->authorize('edit', $data);

            if (@json_decode($multi)) {
                // Check if valid json
                if (is_null(@json_decode($data->{$field}))) {
                    throw new Exception(__('voyager::json.invalid'), 500);
                }

                // Decode field value
                $fieldData = @json_decode($data->{$field}, true);
                $key = null;

                // Check if we're dealing with a nested array for the case of multiple files
                if (is_array($fieldData[0])) {
                    foreach ($fieldData as $index => $file) {
                        // file type has a different structure than images
                        if (!empty($file['original_name'])) {
                            if ($file['original_name'] == $filename) {
                                $key = $index;
                                break;
                            }
                        } else {
                            $file = array_flip($file);
                            if (array_key_exists($filename, $file)) {
                                $key = $index;
                                break;
                            }
                        }
                    }
                } else {
                    $key = array_search($filename, $fieldData);
                }

                // Check if file was found in array
                if (is_null($key) || $key === false) {
                    throw new Exception(__('voyager::media.file_does_not_exist'), 400);
                }

                $fileToRemove = $fieldData[$key]['download_link'] ?? $fieldData[$key];

                // Remove file from array
                unset($fieldData[$key]);

                // Generate json and update field
                $data->{$field} = empty($fieldData) ? null : json_encode(array_values($fieldData));
            } else {
                if ($filename == $data->{$field}) {
                    $fileToRemove = $data->{$field};

                    $data->{$field} = null;
                } else {
                    throw new Exception(__('voyager::media.file_does_not_exist'), 400);
                }
            }

            $row = $dataType->rows->where('field', $field)->first();

            // Remove file from filesystem
            if (in_array($row->type, ['image', 'multiple_images'])) {
                $this->deleteBreadImages($data, [$row], $fileToRemove);
            } else {
                $this->deleteFileIfExists($fileToRemove);
            }

            $data->save();

            return response()->json([
                'data' => [
                    'status'  => 200,
                    'message' => __('voyager::media.file_removed'),
                ],
            ]);
        } catch (Exception $e) {
            $code = 500;
            $message = __('voyager::generic.internal_error');

            if ($e->getCode()) {
                $code = $e->getCode();
            }

            if ($e->getMessage()) {
                $message = $e->getMessage();
            }

            return response()->json([
                'data' => [
                    'status'  => $code,
                    'message' => $message,
                ],
            ], $code);
        }
    }

    /**
     * Remove translations, images and files related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $dataType
     * @param \Illuminate\Database\Eloquent\Model $data
     *
     * @return void
     */
    protected function cleanup($dataType, $data)
    {
        // Delete Translations, if present
        if (is_bread_translatable($data)) {
            $data->deleteAttributeTranslations($data->getTranslatableAttributes());
        }

        // Delete Images
        $this->deleteBreadImages($data, $dataType->deleteRows->whereIn('type', ['image', 'multiple_images']));

        // Delete Files
        foreach ($dataType->deleteRows->where('type', 'file') as $row) {
            if (isset($data->{$row->field})) {
                foreach (json_decode($data->{$row->field}) as $file) {
                    $this->deleteFileIfExists($file->download_link);
                }
            }
        }

        // Delete media-picker files
        $dataType->rows->where('type', 'media_picker')->where('details.delete_files', true)->each(function ($row) use ($data) {
            $content = $data->{$row->field};
            if (isset($content)) {
                if (!is_array($content)) {
                    $content = json_decode($content);
                }
                if (is_array($content)) {
                    foreach ($content as $file) {
                        $this->deleteFileIfExists($file);
                    }
                } else {
                    $this->deleteFileIfExists($content);
                }
            }
        });
    }

    /**
     * Delete all images related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param \Illuminate\Database\Eloquent\Model $rows
     *
     * @return void
     */
    public function deleteBreadImages($data, $rows, $single_image = null)
    {
        $imagesDeleted = false;

        foreach ($rows as $row) {
            if ($row->type == 'multiple_images') {
                $images_to_remove = json_decode($data->getOriginal($row->field), true) ?? [];
            } else {
                $images_to_remove = [$data->getOriginal($row->field)];
            }

            foreach ($images_to_remove as $image) {
                // Remove only $single_image if we are removing from bread edit
                if ($image != config('voyager.user.default_avatar') && (is_null($single_image) || $single_image == $image)) {
                    $this->deleteFileIfExists($image);
                    $imagesDeleted = true;

                    if (isset($row->details->thumbnails)) {
                        foreach ($row->details->thumbnails as $thumbnail) {
                            $ext = explode('.', $image);
                            $extension = '.' . $ext[count($ext) - 1];

                            $path = str_replace($extension, '', $image);

                            $thumb_name = $thumbnail->name;

                            $this->deleteFileIfExists($path . '-' . $thumb_name . $extension);
                        }
                    }
                }
            }
        }

        if ($imagesDeleted) {
            event(new BreadImagesDeleted($data, $rows));
        }
    }

    /**
     * Order BREAD items.
     *
     * @param string $table
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        if (empty($dataType->order_column) || empty($dataType->order_display_column)) {
            return redirect()
                ->route("voyager.{$dataType->slug}.index")
                ->with([
                    'message'    => __('voyager::bread.ordering_not_set'),
                    'alert-type' => 'error',
                ]);
        }

        $model = app($dataType->model_name);
        $query = $model->query();
        if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $query = $query->withTrashed();
        }
        $results = $query->orderBy($dataType->order_column, $dataType->order_direction)->get();

        $display_column = $dataType->order_display_column;

        $dataRow = Voyager::model('DataRow')->whereDataTypeId($dataType->id)->whereField($display_column)->first();

        $view = 'voyager::bread.order';

        if (view()->exists("voyager::$slug.order")) {
            $view = "voyager::$slug.order";
        }

        return Voyager::view($view, compact(
            'dataType',
            'display_column',
            'dataRow',
            'results'
        ));
    }

    public function update_order(Request $request)
    {
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        $this->authorize('edit', app($dataType->model_name));

        $model = app($dataType->model_name);

        $order = json_decode($request->input('order'));
        $column = $dataType->order_column;
        foreach ($order as $key => $item) {
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $i = $model->withTrashed()->findOrFail($item->id);
            } else {
                $i = $model->findOrFail($item->id);
            }
            $i->$column = ($key + 1);
            $i->save();
        }
    }

    public function action(Request $request)
    {
        if (!$request->action || !class_exists($request->action)) {
            throw new \Exception("Action {$request->action} doesn't exist or has not been defined");
        }

        $slug = $this->getSlug($request);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $action = new $request->action($dataType, null);

        return $action->massAction(explode(',', $request->ids), $request->headers->get('referer'));
    }

    /**
     * Get BREAD relations data.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function relation(Request $request)
    {
        $slug = $this->getSlug($request);
        $page = $request->input('page');
        $on_page = 50;
        $search = $request->input('search', false);
        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $method = $request->input('method', 'add');

        $model = app($dataType->model_name);
        if ($method != 'add') {
            $model = $model->find($request->input('id'));
        }

        $this->authorize($method, $model);

        $rows = $dataType->{$method . 'Rows'};
        foreach ($rows as $key => $row) {
            if ($row->field === $request->input('type')) {
                $options = $row->details;
                $model = app($options->model);
                $skip = $on_page * ($page - 1);

                $additional_attributes = $model->additional_attributes ?? [];

                // Apply local scope if it is defined in the relationship-options
                if (isset($options->scope) && $options->scope != '' && method_exists($model, 'scope' . ucfirst($options->scope))) {
                    $model = $model->{$options->scope}();
                }

                // If search query, use LIKE to filter results depending on field label
                if ($search) {
                    // If we are using additional_attribute as label
                    if (in_array($options->label, $additional_attributes)) {
                        $relationshipOptions = $model->get();
                        $relationshipOptions = $relationshipOptions->filter(function ($model) use ($search, $options) {
                            return stripos($model->{$options->label}, $search) !== false;
                        });
                        $total_count = $relationshipOptions->count();
                        $relationshipOptions = $relationshipOptions->forPage($page, $on_page);
                    } else {
                        $total_count = $model->where($options->label, 'LIKE', '%' . $search . '%')->count();
                        $relationshipOptions = $model->take($on_page)->skip($skip)
                            ->where($options->label, 'LIKE', '%' . $search . '%')
                            ->get();
                    }
                } else {
                    $total_count = $model->count();
                    $relationshipOptions = $model->take($on_page)->skip($skip)->get();
                }

                $results = [];

                if (!$row->required && !$search && $page == 1) {
                    $results[] = [
                        'id'   => '',
                        'text' => __('voyager::generic.none'),
                    ];
                }

                // Sort results
                if (!empty($options->sort->field)) {
                    if (!empty($options->sort->direction) && strtolower($options->sort->direction) == 'desc') {
                        $relationshipOptions = $relationshipOptions->sortByDesc($options->sort->field);
                    } else {
                        $relationshipOptions = $relationshipOptions->sortBy($options->sort->field);
                    }
                }

                foreach ($relationshipOptions as $relationshipOption) {
                    $results[] = [
                        'id'   => $relationshipOption->{$options->key},
                        'text' => $relationshipOption->{$options->label},
                    ];
                }

                return response()->json([
                    'results'    => $results,
                    'pagination' => [
                        'more' => ($total_count > ($skip + $on_page)),
                    ],
                ]);
            }
        }

        // No result found, return empty array
        return response()->json([], 404);
    }

    protected function findSearchableRelationshipRow($relationshipRows, $searchKey)
    {
        return $relationshipRows->filter(function ($item) use ($searchKey) {
            if ($item->details->column != $searchKey) {
                return false;
            }
            if ($item->details->type != 'belongsTo') {
                return false;
            }

            return !$this->relationIsUsingAccessorAsLabel($item->details);
        })->first();
    }

    protected function getSortableColumns($rows)
    {
        return $rows->filter(function ($item) {
            if ($item->type != 'relationship') {
                return true;
            }
            if ($item->details->type != 'belongsTo') {
                return false;
            }

            return !$this->relationIsUsingAccessorAsLabel($item->details);
        })
            ->pluck('field')
            ->toArray();
    }

    protected function relationIsUsingAccessorAsLabel($details)
    {
        return in_array($details->label, app($details->model)->additional_attributes ?? []);
    }
}
