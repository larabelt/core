<?php

namespace Belt\Core\Http\Controllers\Api;

use Translate;
use Belt\Core\Behaviors\TranslatableInterface;
use Belt\Core\Translation;
use Belt\Core\Http\Controllers\ApiController;
use Belt\Core\Http\Requests;
use Belt\Core\Http\Controllers\Behaviors\Morphable;
use Illuminate\Http\Request;

class TranslatablesController extends ApiController
{

    use Morphable;

    /**
     * @var Translation
     */
    public $translations;

    /**
     * TranslatablesController constructor.
     * @param Translation $translation
     */
    public function __construct(Translation $translation)
    {
        $this->translations = $translation;
    }

    /**
     * @param $translatable_type
     * @param $translatable_id
     * @param $id
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     */
    public function translation($translatable_type, $translatable_id, $id)
    {
        $qb = $this->translations->query();
        $qb->where('translatable_type', $translatable_type);
        $qb->where('translatable_id', $translatable_id);

        if (is_numeric($id)) {
            $qb->where('id', $id);
        } else {
            $qb->where('translatable_column', $id);
        }

        return $qb->first() ?: $this->abort(404);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $translatable_type
     * @param $translatable_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, $translatable_type, $translatable_id)
    {
        $request = Requests\PaginateTranslatables::extend($request);

        $translatable = $this->morph($translatable_type, $translatable_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $translatable);

        $request->merge([
            'translatable_id' => $translatable->id,
            'translatable_type' => $translatable->getMorphClass()
        ]);

        $paginator = $this->paginator($this->translations->query(), $request);

        $response = $paginator->toArray();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in core.
     *
     * @param Requests\StoreTranslation $request
     * @param $translatable_type
     * @param $translatable_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Requests\StoreTranslation $request, $translatable_type, $translatable_id)
    {
        /**
         * @var $translatable TranslatableInterface
         */
        $translatable = $this->morph($translatable_type, $translatable_id);

        $this->authorize('update', $translatable);

        $input = $request->all();

        if (array_get($input, '_auto_translate')) {
            $input['value'] = Translate::translate($translatable->getOriginal($input['translatable_column']), $input['locale']);
        }

        $translation = $translatable->saveTranslation($input['translatable_column'], $input['value'], $input['locale']);

        $this->itemEvent('created', $translation);
        $this->itemEvent('saved', $translation);

        return response()->json($translation, 201);
    }

    /**
     * Update the specified resource in core.
     *
     * @param Requests\UpdateTranslation $request
     * @param $translatable_type
     * @param $translatable_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Requests\UpdateTranslation $request, $translatable_type, $translatable_id, $id)
    {
        $translatable = $this->morph($translatable_type, $translatable_id);

        $this->authorize('update', $translatable);

        $translation = $this->translation($translatable_type, $translatable_id, $id);

        $input = $request->all();

        if (array_get($input, '_auto_translate')) {
            $input['value'] = Translate::translate($translatable->getOriginal($translation->translatable_column), $translation->locale);
        }

        $this->set($translation, $input, [
            'value',
        ]);

        $translation->save();

        $this->itemEvent('updated', $translation);
        $this->itemEvent('saved', $translation);

        return response()->json($translation);
    }

    /**
     * Display the specified resource.
     *
     * @param $translatable_type
     * @param $translatable_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($translatable_type, $translatable_id, $id)
    {
        $translatable = $this->morph($translatable_type, $translatable_id);

        $this->authorize(['view', 'create', 'update', 'delete'], $translatable);

        $translation = $this->translation($translatable_type, $translatable_id, $id);

        return response()->json($translation);
    }

    /**
     * Remove the specified resource from core.
     *
     * @param $translatable_type
     * @param $translatable_id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Belt\Core\Http\Exceptions\ApiException
     * @throws \Belt\Core\Http\Exceptions\ApiNotFoundHttpException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($translatable_type, $translatable_id, $id)
    {
        $translatable = $this->morph($translatable_type, $translatable_id);

        $this->authorize('update', $translatable);

        $translation = $this->translation($translatable_type, $translatable_id, $id);

        $translation->delete();

        $this->itemEvent('translations.deleted', $translatable);

        return response()->json(null, 204);
    }
}
