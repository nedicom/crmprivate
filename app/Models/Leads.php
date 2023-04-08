<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Services;


  class Leads extends Model
  {
      use HasFactory;

      public function userFunc(){
          return $this->belongsTo(USER::class, 'lawyer');
      }

      public function responsibleFunc(){
          return $this->belongsTo(USER::class, 'responsible');
      }

      public function servicesFunc(){
          return $this->belongsTo(Services::class, 'service');
      }

        /*public function scopeLawyer($query, $type){
              return $query->where('lawyer', $type);
        }
        public function scopeStatus($query, $type){
              return $query->where('status', $type);
        }
        public function scopeSource($query, $type){
              return $query->where('source', $type);
        }
        public function scopeResponsible($query, $type){
              return $query->where('responsible', $type);
        }*/

    }
