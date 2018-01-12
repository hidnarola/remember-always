<?php

/**
 * Donate Controller
 * Make donations to fund raiser profile
 * @author KU 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Donate extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display donation listing page of particular fundraiser profile
     * @param string $slug
     */
    public function index($slug = null) {
        if (!is_null($slug)) {
            $fundraiser = $this->users_model->sql_select(TBL_FUNDRAISER_PROFILES . ' f', 'f.id as fundraiser_id,p.slug,p.id,p.firstname,p.lastname,f.title,f.goal,f.total_donation,f.end_date,f.details', ['where' => ['p.slug' => $slug, 'p.is_delete' => 0, 'p.is_published' => 1]], [
                'single' => true,
                'join' => [
                    array('table' => TBL_PROFILES . ' p', 'condition' => 'p.id=f.profile_id'),
            ]]);
            if (!empty($fundraiser)) {
                $data['fundraiser_media'] = $this->users_model->sql_select(TBL_FUNDRAISER_MEDIA, 'media,type', ['where' => ['fundraiser_profile_id' => $fundraiser['fundraiser_id']]]);
                $data['donations'] = $this->users_model->sql_select(TBL_DONATIONS . ' d', 'u.firstname,u.lastname,u.profile_image,d.details,d.amount,d.created_at', ['where' => ['d.is_delete' => 0, 'p.slug' => $slug]], [
                    'join' => [
                        array('table' => TBL_PROFILES . ' p', 'condition' => 'd.profile_id=p.id'),
                        array('table' => TBL_USERS . ' u', 'condition' => 'd.user_id=u.id'),
                ]]);
                $data['fundraiser'] = $fundraiser;
                $data['title'] = $fundraiser['title'] . ' | Donations';
                $this->template->load('default', 'donate/index', $data);
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    public function first() {
        $data['title'] = 'first';
        $this->template->load('default', 'donate/first', $data);
    }

    public function second() {
        $data['title'] = 'second';
        $this->template->load('default', 'donate/second', $data);
    }

    public function third() {
        $data['title'] = 'third';
        $this->template->load('default', 'donate/third', $data);
    }

}
