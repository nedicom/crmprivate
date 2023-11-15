<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
  public function addSource(Request $req)
  {
      $source = new Source();
      $source->name = $req->input('sourcename');
      $source->save();
      return redirect()->route('leads')->with('success', 'Все в порядке, источник лидов добавлен');
  }
}
