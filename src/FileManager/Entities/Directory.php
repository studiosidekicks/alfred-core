<?php

namespace Studiosidekicks\Alfred\FileManager\Entities;

use Studiosidekicks\Alfred\Core\Entities\AlfredModel;

class Directory extends AlfredModel
{
    protected $table = 'directories';
    protected $fillable = ['name', 'parent_id'];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function parent()
    {
        return $this->belongsTo(Directory::class, 'parent_id');
    }

    public function subdirectories()
    {
        return $this->hasMany(Directory::class, 'parent_id');
    }

    public function allSubdirectories()
    {
        return $this->subdirectories()->with('allSubdirectories');
    }
}