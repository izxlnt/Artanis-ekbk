<?php

/**
 * Which record each by-id route opens, so App\Http\Middleware\EnsureRecordInScope can check that the
 * record belongs to the logged-in user (PHD: district, JPN: state, IBK: own kilang).
 *
 * Kinds: Form{A,B,C,D,4D,4E,5D,5E} = a form row id, Shuttle = a kilang id, Batch, User (an applicant),
 * Pengumuman (PHD district announcement), PengumumanJpn (JPN state announcement).
 * Routes not listed are not checked (e.g. the IBK form-fill routes, where {id} is a month or quarter
 * and the data always comes from the logged-in user's own kilang).
 */
return [
    // off = do nothing, log = only log what would be blocked (default), enforce = respond 403
    'mode' => env('RECORD_SCOPE_MODE', 'log'),

    // 'Kind' reads the record from the {id} route parameter; 'Kind:name' reads it from the route
    // parameter or request input called "name". DaerahHutan = a district name (checked against the
    // JPN's state).
    'routes' => [
        'jpn/shuttle-list/email' => 'DaerahHutan:daerah_hutan',
        'phd/notifikasi-kilang/shuttle-3/send' => 'Shuttle:shuttle_id',
        'phd/notifikasi-kilang/shuttle-4/send' => 'Shuttle:shuttle_id',
        'phd/notifikasi-kilang/shuttle-5/send' => 'Shuttle:shuttle_id',
        'jpn/pengumuman-delete-jpn/{id}' => 'PengumumanJpn',
        'jpn/pengumuman-edit-jpn/{id}' => 'PengumumanJpn',
        'jpn/pengumuman-kemaskini-jpn/{id}' => 'PengumumanJpn',
        'jpn/shuttle-4-view-formC/{id}' => 'FormC',
        'jpn/shuttle-view-form4D/{id}' => 'Form4D',
        'jpn/shuttle-view-form4E/{id}' => 'Form4E',
        'jpn/shuttle-view-form5D/{id}' => 'Form5D',
        'jpn/shuttle-view-form5E/{id}' => 'Form5E',
        'jpn/shuttle-view-formA/{id}' => 'FormA',
        'jpn/shuttle-view-formB/{id}' => 'FormB',
        'jpn/shuttle-view-formC/{id}' => 'FormC',
        'jpn/shuttle-view-formD/{id}' => 'FormD',
        'pengguna/edit-shuttle-3B/{id}' => 'FormB',
        'pengguna/edit-shuttle-3C/{id}' => 'FormC',
        'pengguna/edit-shuttle-3D/{id}' => 'FormD',
        'pengguna/edit-shuttle-4D/{id}' => 'Form4D',
        'pengguna/edit-shuttle-4E/{id}' => 'Form4E',
        'pengguna/shuttle-3-formA/update/{id}' => 'Shuttle',
        'pengguna/shuttle-4-formA/update/{id}' => 'Shuttle',
        'pengguna/shuttle-4-view-formC/{id}' => 'FormC',
        'pengguna/shuttle-5-edit-formD/{id}' => 'Form5D',
        'pengguna/shuttle-5-edit-formE/{id}' => 'Form5E',
        'pengguna/shuttle-5-formA/update/{id}' => 'Shuttle',
        'pengguna/shuttle-5-view-formC/{id}' => 'FormC',
        'pengguna/shuttle-view-form4D/{id}' => 'Form4D',
        'pengguna/shuttle-view-form4E/{id}' => 'Form4E',
        'pengguna/shuttle-view-form5D/{id}' => 'Form5D',
        'pengguna/shuttle-view-form5E/{id}' => 'Form5E',
        'pengguna/shuttle-view-formA/{id}' => 'FormA',
        'pengguna/shuttle-view-formB/{id}' => 'FormB',
        'pengguna/shuttle-view-formC/{id}' => 'FormC',
        'pengguna/shuttle-view-formD/{id}' => 'FormD',
        'phd/batch/shuttle-3/hantar/submit/{id}' => 'Batch',
        'phd/batch/shuttle-4/hantar/submit/{id}' => 'Batch',
        'phd/batch/shuttle-5/hantar/submit/{id}' => 'Batch',
        'phd/lampiran-permohonan/{id}' => 'User',
        'phd/pengumuman-delete/{id}' => 'Pengumuman',
        'phd/pengumuman-edit/{id}' => 'Pengumuman',
        'phd/pengumuman-kemaskini/{id}' => 'Pengumuman',
        'phd/sahkan-lampiran-permohonan/{id}' => 'User',
        'phd/sahkan-permohonan-phd/{id}' => 'User',
        'phd/shuttle-3-update-status-formA/{id}' => 'FormA',
        'phd/shuttle-3-update-status-formB/{id}' => 'FormB',
        'phd/shuttle-3-update-status-formC/{id}' => 'FormC',
        'phd/shuttle-3-update-status-formD/{id}' => 'FormD',
        'phd/shuttle-4-update-status-form4D/{id}' => 'Form4D',
        'phd/shuttle-4-update-status-form4E/{id}' => 'Form4E',
        'phd/shuttle-4-view-formC/{id}' => 'FormC',
        'phd/shuttle-4-view-formD/{id}' => 'Form4D',
        'phd/shuttle-4-view-formE/{id}' => 'Form4E',
        'phd/shuttle-5-update-status-formD/{id}' => 'Form5D',
        'phd/shuttle-5-update-status-formE/{id}' => 'Form5E',
        'phd/shuttle-5-view-formD/{id}' => 'Form5D',
        'phd/shuttle-5-view-formE/{id}' => 'Form5E',
        'phd/shuttle-view-formA/{id}' => 'FormA',
        'phd/shuttle-view-formB/{id}' => 'FormB',
        'phd/shuttle-view-formC/{id}' => 'FormC',
        'phd/shuttle-view-formD/{id}' => 'FormD',
        'phd/view-form4C/{id}' => 'FormC',
        'phd/view-form4D/{id}' => 'Form4D',
        'phd/view-form5D/{id}' => 'Form5D',
        'phd/view-form5E/{id}' => 'Form5E',
        'phd/view-formA/{id}' => 'FormA',
        'phd/view-formB/{id}' => 'FormB',
        'phd/view-formC/{id}' => 'FormC',
        'phd/view-formD/{id}' => 'FormD',
        'phd/view-formE/{id}' => 'Form4E',
        'shuttle-3-view-form3B/{id}' => 'Shuttle',
    ],
];
