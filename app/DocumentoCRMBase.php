<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentoCRMBase extends Model
{
    protected $table = 'documentocrmbase';
    protected $primaryKey = 'idDocumentoCRMBase';

    protected $fillable = ['DocumentoCRM_idDocumentoCRM','DocumentoCRM_idBase'];

    public $timestamps = false;

    
}