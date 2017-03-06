<?php

namespace Belt\Core\Http\Controllers\Api;

use Belt\Core\Helpers\MorphHelper;
use Belt\Core\Http\Controllers\ApiController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TreeController extends ApiController
{

    /**
     * @var MorphHelper
     */
    public $morphHelper;

    public function __construct(MorphHelper $morphHelper)
    {
        $this->morphHelper = $morphHelper;
    }

    /**
     * @param $node_type
     * @param $node_id
     * @return Model
     */
    public function node($node_type, $node_id)
    {
        $node = $this->morphHelper->morph($node_type, $node_id);

        return $node ?: $this->abort(404);
    }

    /**
     * Store a newly created resource in core.
     *
     * @todo Validation, Testing
     *
     * @param  Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $node_type, $node_id)
    {
        $node = $this->node($node_type, $node_id);

        $this->authorize('update', $node);

        $neighbor = $this->node($node_type, $request->get('neighbor_id'));

        $move = $request->get('move');

        if ($move == 'before') {
            $result = $node->insertBeforeNode($neighbor);
        }

        if ($move == 'after') {
            $result = $node->insertAfterNode($neighbor);
        }

        if ($move == 'in') {
            $result = $neighbor->appendNode($node);
        }

        return response()->json([$result], 201);
    }

}
