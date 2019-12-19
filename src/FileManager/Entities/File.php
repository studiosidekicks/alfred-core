<?php

namespace Studiosidekicks\Alfred\FileManager\Entities;

use Studiosidekicks\Alfred\Core\Entities\AlfredModel;

class File extends AlfredModel
{
    protected $table = 'files';
    protected $fillable = ['filename', 'original_filename', 'alternate_text', 'type'];

    public function directory()
    {
        return $this->belongsTo(Directory::class);
    }

}