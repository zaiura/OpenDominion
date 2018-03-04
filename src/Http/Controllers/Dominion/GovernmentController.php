<?php

namespace OpenDominion\Http\Controllers\Dominion;

class GovernmentController extends AbstractDominionController
{
    public function getIndex()
    {
        return view('pages.dominion.government', [

        ]);
    }
}
