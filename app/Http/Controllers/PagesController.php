<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function learning()
    {
        return view('pages.learning');
    }

    public function bootcamp()
    {
        return view('pages.bootcamp');
    }

    public function webinar()
    {
        return view('pages.webinar');
    }

    public function deskripsiKelas()
    {
        return view('pages.deskripsi_kelas');
    }

    public function detailKursus()
    {
        return view('pages.detail_kursus');
    }

    public function formPayments()
    {
        return view('pages.form_payments');
    }

    public function beliSekarang()
    {
        return view('pages.beli_sekarang');
    }

    public function formPendaftaran()
    {
        return view('pages.form_pendaftaran');
    }

    public function kelas()
    {
        return view('pages.kelas');
    }
}
