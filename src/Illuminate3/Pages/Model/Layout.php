<?php

namespace Illuminate3\Pages\Model;

class Layout extends \Eloquent
{

    protected $table = 'layouts';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'title',
        'name',
    );

    /**
     * @return \Illuminate3\Pages\Model\Section
     */
    public function sections()
    {
        return $this->belongsToMany('Illuminate3\Pages\Model\Section');
    }

    /**
     * @return \Illuminate3\Pages\Model\Page
     */
    public function pages()
    {
        return $this->hasMany('Illuminate3\Pages\Model\Page');
    }
}

