<?php
$current_page = 'home';

if(array_key_exists('page',$_GET)) {
    $current_page = $_GET['page'];
}

switch ($current_page) {
	
	case 'home':
	require_once('home.php');
	break;
	
	case 'check-pefindo-ho':
	require_once('check_pefindo_ho.php');
	break;
	
	case 'result-pefindo':
	require_once('result_pefindo.php');
	break;
	
	case 'individual':
	require_once('individual1.php');
	break;
	
	case 'individual-ho':
	require_once('individual-ho.php');
	break;
	
	case 'individual-prospek':
	require_once('individual-prospek.php');
	break;
	
	case 'individual-check':
	require_once('individual-check.php');
	break;

	case 'individual-check-slik':
	require_once('individual-check-slik.php');
	break;



	# -- company page --

	case 'company':
		require_once('company1.php');
		break;

	case 'company-piloting':
		require_once('company-piloting.php');
		break;

	case 'company-prospek':
		require_once('company-prospek.php');
		break;

	case 'company-prospek-piloting':
		require_once('company-prospek-piloting.php');
		break;

	case 'company-check':
		require_once('company-check.php');
		break;

	case 'company-check-piloting':
		require_once('company-check-piloting.php');
		break;

	case 'company-edit':
		require_once('company-edit.php');
		break;

	case 'input-company-pengurus':
		require_once('input-company-pengurus.php');
		break;

	case 'company-stakeholder-check':
		require_once('company-stakeholder-check.php');
		break;

	case 'company-stakeholder-check-pefindo':
		# added on 20-06-2022
		require_once('company-stakeholder-check-pefindo.php');
		break;

	case 'slik-note-company':
		require_once('pages/slik-note-company.php');
		break;

	case 'note-detail-company':
		require_once('pages/note-detail-company.php');
		break;

	case 'slik-detail-company':
		require_once('pages/slik-detail-company.php');
		break;

	case 'pefindonodata-piloting':
		require_once('pages/pefindonodata-piloting.php');
		break;

	case 'scoring-company':
		require_once('scoring-company.php');
		break;

	case 'scoring-company-piloting':
		require_once('scoring-company-piloting.php');
		break;

	case 'detail-informasi-company':
		require_once('detail-informasi-company.php');
		break;

	case 'prospek-group-company':
		require_once('pages/prospek-group-company.php');
		break;

	case 'company-order-list':
		require_once('company-order-list.php');
		break;
		
	case 'company-order-detail':
		require_once('company-order-detail.php');
		break;
		
	case 'company-order-edit-data':
		require_once('company-order-edit-data.php');
		break;
		
	case 'company-order-edit-stakeholder':
		require_once('company-order-edit-stakeholder.php');
		break;

	// -- RAK --
	case 'detail-rak-company-submitter':
		require_once('detail-rak-company-submitter.php');
		break;
		
	case 'detail-rak-company-branch':
		require_once('detail-rak-company-branch.php');
		break;
		
	case 'detail-rak-company-HO':
		require_once('detail-rak-company-HO.php');
		break;
		
	case 'detail-rak-company-view':
		require_once('detail-rak-company-view-only.php');
		break;
	
	case 'action-reminder-fleet-RAK':
		require_once('action-reminder-fleet-RAK.php');
		break;
	// -- RAK --		

	# -- end of company page --



	case 'scoring-individual':
	require_once('scoring-individual.php');
	break;
	
	case 'history':
	require_once('pages/history.php');
	break;

	case 'pefindonodata':
	require_once('pages/pefindonodata.php');
	break;
	
	case 'slik-result':
	require_once('pages/slik-result.php');
	break;
	
	case 'slik-detail':
	require_once('pages/slik-detail.php');
	break;

	case 'slik-note':
	require_once('pages/slik-note.php');
	break;

	case 'note-detail':
	require_once('pages/note-detail.php');
	break;

	case 'log-pefindo':
	require_once('pages/log-pefindo.php');
	break;

	case 'log-slik':
	require_once('pages/log-slik.php');
	break;

	case 'log-dukcapil':
	require_once('pages/log-dukcapil1.php');
	break;
	
	case 'log-scoring':
	require_once('pages/log-scoring.php');
	break;
	
	// Ahmad Arkana Dhanisworo 20250903

	case 'supervisor-req-slik':
		require_once('pages/supervisor-req-slik.php');
		break;
	//END
	
	case 'prospek-detail':
	require_once('pages/prospek-detail.php');
	break;
		
	case 'test':
	require_once('test.php');
	break;

	case 'prospek-group':
	require_once('pages/prospek-group-slik.php');
	break;
	
	case 'error':
	require_once('error.php');
	break;
	
	case 'individual-manual':
	require_once('individual-manual.php');
	break;
	
	//ahmad arkana dhanisworo - 20251120
	case 'individual-manual-new':
		require_once('individual-manual-new.php');
		break;

	case 'individual-manual-detail-new':
		require_once('individual-manual-detail-new.php');
		break;

	case 'company-manual-new':
		require_once('company-manual-new.php');
		break;

	case 'company-manual-detail-new':
		require_once('company-manual-detail-new.php');
		break;

	case 'fasilitas-manual-detail-new':
		require_once('fasilitas-manual-detail-new.php');
		break;
	//end
	
	case 'company-manual':
	require_once('company-manual.php');
	break;
	
	case 'dukcapil-manual':
	require_once('dukcapil-manual.php');
	break;
	
	case 'check-blacklist':
	require_once('check-blacklist.php');
	break;
	
	case 'check-dukcapil':
	require_once('check-dukcapil.php');
	break;
	
	case 'check-pefindo':
	require_once('check-pefindo.php');
	break;
	
	case 'detail-log-dukcapil':
	require_once('pages/detail-log-dukcapil.php');
	break;
	
	case 'unlock-dukcapil':
	require_once('unlock-dukcapil.php');
	break;
	
	case 'unlock-detail':
	require_once('unlock-detail.php');
	break;
	
	case 'check_dukcapil_trace':
	require_once('check-dukcapil_trace.php');
	break;
	
	case 'request-mh':
	require_once('request-mh.php');
	break;
	
	case 'detail-request-mh':
	require_once('detail-request-mh.php');
	break;
	
	case 'pengecekan-mh':
	require_once('pengecekan-request.php');
	break;
	
	case 'detail-pengecekan-mh':
	require_once('detail-pengecekan-request.php');
	break;
	
	case 'check-request-mh':
	require_once('check-request-mh.php');
	break;
	
	case 'check-request-mh-penjamin':
	require_once('check-request-mh-penjamin.php');
	break;
	
	case 'hasil-pengecekan':
	require_once('hasil-pengecekan.php');
	break;
	
	case 'return-mh':
	require_once('return-mh.php');
	break;
	
	case 'detail-check':
	require_once('detail-check.php');
	break;
	
	case 'detail-pengkinian-data-dukcapil':
	require_once('detail-pengkinian-data-dukcapil.php');
	break;
	
	case 'pengkinian-data-dukcapil':
	require_once('pengkinian-data-dukcapil.php');
	break;
	
	case 'reject-order':
	require_once('reject-order.php');
	break;
		
	case 'upload-spk':
	require_once('pages/upload-spk.php');
	break;
	
	case 'detail-upload-spk':
	require_once('pages/detail-upload-spk.php');
	break;                                                                                                                                                                                               
	
	case 'dukcapil-ho':
	require_once('dukcapil-ho.php');
	break;
	
	case 'detail-informasi':
	require_once('detail-informasi.php');
	break;
	
	
	case 'individual-prospek1':
	require_once('individual-prospek1.php');
	break;
	
	case 'check_pefindo_new':
	require_once('check_pefindo_new.php');
	break;
	
	case 'dukcapil-reject':
	require_once('dukcapil-reject.php');
	break;

	case 'note-reject-detail':
	require_once('note-reject-detail.php');
	break;
	
	case 'detail-informasi-proses':
	require_once('detail-informasi-proses.php');
	break;

	case 'detail-informasi-dukcapil':
	require_once('detail-informasi-dukcapil.php');
	break;
		
	case 'individual-ho-new':
	require_once('individual-ho-new.php');
	break;
	
	case 'prospek-group-new':
	require_once('pages/prospek-group-new.php');
	break;
	
	
	case 'detail-informasi-get':
	require_once('detail-informasi-get.php');
	break;
	
	case 'report_dashboard':
	require_once('report_dashboard.php');
	break;	
	
	case 'slik-note1':
	require_once('pages/slik-note1.php');
	break;	
	
	case 'slik_upload_api':
	require_once('slik_upload_api.php');
	break;	
	
	case 'slik_upload_api_txt':
	require_once('slik_upload_api_txt.php');
	break;
	
	case 'detail-pengecekan-mh-branch':
	require_once('detail-pengecekan-request-branch.php');
	break;
	
	case 'check-request-mh-blacklist':
	require_once('check-request-mh-blacklist.php');
	break;
	
	case 'prospek-group-vbs':
	require_once('pages/prospek-group-vbs.php');
	break;
	
	case 'view-request':
	require_once('view_detail_request.php');
	break;
	case 'view-inquiry':
	require_once('view-inquiry.php');
	break;
	case 'aproval':
	require_once('aproval.php');
	break;
	case 'aproval-inquiry':
	require_once('aproval-inquiry.php');
	break;
	case 'aproval-detail':
	require_once('aproval-detail.php');
	break;	
	
	case 'detail-koreksi-mh':
	require_once('detail-koreksi-mh.php');
	break;
	
	case 'return-approval':
	require_once('return-approval.php');
	break;
	
	case 'verifikasi_final':
	require_once('verifikasi_final.php');
	break;
	
	case 'detail-request-mh-vers':
	require_once('detail-request-mh-vers.php');
	break;
	
		case 'detail-pengecekan-mh-branch1':
	require_once('detail-pengecekan-request-branch1.php');
	break;
	
		
	case 'detail-request-mh1':
	require_once('detail-request-mh1.php');
	break;
	
	case 'check-request-mh-slik':
	require_once('check-request-mh-slik.php');
	break;
	
	case 'unlock-reject':
	require_once('unlock-reject.php');
	break;
	
	case 'check-notfound':
	require_once('check-notfound.php');
	break;
	
	case 'individual-prospek-ver2':
	require_once('individual-prospek-ver2.php');
	break;
	
	case 'check-blacklist-prospect':
	require_once('check-blacklist-prospect.php');
	break;
	
	case 'check-request-mh-prospect':
	require_once('check-request-mh-prospect.php');
	break;
	
	case 'check-notfound-piloting':
	require_once('check-notfound-piloting.php');
	break;
	
		case 'cek-ulang-dukcapil':
	require_once('cek-ulang-dukcapil.php');
	break;
	
	case 'cek-ulang-dukcapil-detail':
	require_once('cek-ulang-dukcapil-detail.php');
	break;
	
	case 'check-dukcapil-slik':
	require_once('check-dukcapil-slik.php');
	break;
	
	case 'check-blacklist-prospect':
	require_once('check-blacklist-prospect.php');
	break;
	
	case 'cek-ulang-dukcapil-detail-old':
	require_once('cek-ulang-dukcapil-detail-old.php');
	break;

	case 'check-request-mh-blacklist-new':
	require_once('check-request-mh-blacklist-new.php');
	break;
	
	case 'check-request-mh-blacklist-new1':
	require_once('check-request-mh-blacklist-new.php');
	break;
	
	case 'check-slik-piloting':
	require_once('check-slik-piloting.php');
	break;
	
	case 'dukcapil-ho-new':
	require_once('dukcapil-ho-new.php');
	break;
	
	case 'check-dukcapil-slik-new':
	require_once('check-dukcapil-slik-new.php');
	break;
	
	case 'check-request-mh-new':
	require_once('check-request-mh-new.php');
	break;
	
	case 'dukcapil-manual-new':
	require_once('dukcapil-manual-new.php');
	break;
	
	case 'form_verifikasi_status_nikah':
	require_once('form_verifikasi_status_nikah.php');
	break;
	
	case 'tasklist-status-nikah':
	require_once('tasklist-status-nikah.php');
	break;
	
		
	case 'input-calon-karyawan':
	require_once('input-calon-karyawan.php');
	break;
	

	
	case 'tasklist-pengecekan-slik':
	require_once('tasklist-pengecekan-slik.php');
	break;
	
	case 'detail-karyawan-baru':
	require_once('detail-karyawan-baru.php');
	break;
	
	case 'detail-calon-vendor':
	require_once('detail-calon-vendor.php');
	break;
	
	case 'slik-detail-new-mapping':
	require_once('pages/slik-detail-new-mapping.php');
	break;
	
	case 'input-vendor':
	require_once('input-vendor.php');
	break;

	case 'input-debitur-existing':
	require_once('input-debitur-existing.php');
	break;
	
	case 'detail-debitur-existing':
	require_once('detail-debitur-existing.php');
	break;
	
	case 'slik-note-new-mapping':
	require_once('pages/slik-note-new-mapping.php');
	break;
	
	case 'note-detail-new-mapping':
	require_once('pages/note-detail-new-mapping.php');
	break;
	
	case 'cetak_surat_pernyataan':
	require_once('cetak_surat_pernyataan.php');
	break;
	
	case 'testpdf':
	require_once('testpdf.php');
	break;
	
	case 'form_verifikasi_status':
	require_once('form_verifikasi_status.php');
	break;
	
	case 'cek-ulang-dukcapil-detail-new':
	require_once('cek-ulang-dukcapil-detail-new.php');
	break;
	
	case 'tasklist-status-verifikasi':
	require_once('tasklist-status-verifikasi.php');
	break;
	
	case 'tasklist-loa-verifikasi':
	require_once('tasklist-loa-verifikasi.php');
	break;
	
	case 'detail-approval-loa':
	require_once('detail-approval-loa.php');
	break;
	
	case 'tasklist-loa-verifikasi-inquiry':
	require_once('tasklist-loa-verifikasi-inquiry.php');
	break;
	
	case 'detail-approval-loa-inquiry':
	require_once('detail-approval-loa-inquiry.php');
	break;
	
	
	case 'detail-deviasi-ca':
	require_once('detail-deviasi-ca.php');
	break;
	
	case 'detail-approval-tdp':
	require_once('detail-approval-tdp.php');
	break;
	
	case 'detail-approval-tdp-piloting':
	require_once('detail-approval-tdp-piloting.php');
	break;
	
	case 'tasklist-loa-tdp':
	require_once('tasklist-loa-tdp.php');
	break;
	
	case 'tasklist-deviasi-ca':
	require_once('tasklist-deviasi-ca.php');
	break;
	
	case 'upload-bukti-pelunasan':
	require_once('upload-bukti-pelunasan.php');
	break;
	
	case 'tasklist-bukti-pelunasan':
	require_once('tasklist-bukti-pelunasan.php');
	break;
	
	case 'tasklist-loa-tdp-inquiry':
	require_once('tasklist-loa-tdp-inquiry.php');
	break;
	
	
	case 'detail-approval-loa-tdp-inquiry':
	require_once('detail-approval-loa-tdp-inquiry.php');
	break;
	
	
	
	case 'tasklist-rak':
	require_once('tasklist-rak.php');
	break;
		
	case 'detail-rak':
	require_once('detail-rak.php');
	break;
	
	case 'detail-rak-bm':
	require_once('detail-rak-bm.php');
	break;
	
	case 'detail-rak-am':
	require_once('detail-rak-am.php');
	break;
	
	case 'detail-form-rak':
	require_once('detail-form-rak.php');
	break;
	
	case 'tasklist-loa-rak':
	require_once('tasklist-loa-rak.php');
	break;
	
	case 'tasklist-loa-rak-inquiry':
	require_once('tasklist-loa-rak-inquiry.php');
	break;
	
	case 'check-credit-internal':
	require_once('check-credit-internal.php');
	break;

	
	case 'detail-deviasi-ca-piloting':
	require_once('detail-deviasi-ca-piloting.php');
	break;
	
	case 'detail-approval-tdp-piloting.php':
	require_once('detail-approval-tdp-piloting.php.php');
	break;
	
	case 'detail-approval-loa-tdp-inquiry-piloting':
	require_once('detail-approval-loa-tdp-inquiry-piloting.php');
	break;
	
	case 'tasklist-vbs-inquiry':
	require_once('tasklist-vbs-inquiry.php');
	break;
	
	case 'tasklist-deviasi-ca-piloting':
	require_once('tasklist-deviasi-ca-piloting.php');
	break;
	
	case 'detail-request-mh-view':
	require_once('detail-request-mh-view.php');
	break;
	
		
	case 'rincian_fasilitas':
	require_once('rincian_fasilitas.php');
	break;
	
	case 'rincian_fasilitas_not_aktif':
	require_once('rincian_fasilitas_not_aktif.php');
	break;
	
	case 'rincian_fasilitas_penjamin':
	require_once('rincian_fasilitas_penjamin.php');
	break;
	
		case 'tasklist_hasil_survey':
	require_once('tasklist_hasil_survey.php');
	break;
	
	case 'dukcapil-manual-new1':
	require_once('dukcapil-manual-new1.php');
	break;
	
	case 'tasklist-ideb':
	require_once('tasklist-ideb.php');
	break;

	case 'detail-informasi-ideb':
	require_once('detail-informasi-ideb.php');
	break;
	
	case 'tasklist-robot-slik':
	require_once('tasklist-robot-slik.php');
	break;
	
	case 'detail-informasi-ideb-company':
	require_once('detail-informasi-ideb-company.php');
	break;
	
	case 'tasklist-robot-slik-detail':
	require_once('tasklist-robot-slik-detail.php');
	break;
	
	case 'detail-informasi-ideb-new':
	require_once('detail-informasi-ideb-new.php');
	break;
	
	case 'detail-informasi-ideb-ho':
	require_once('detail-informasi-ideb-ho.php');
	break;
	
	case 'detail-rak-bm-test':
	require_once('detail-rak-bm-test.php');
	break;
	
	case 'detail-rak-test':
	require_once('detail-rak-test.php');
	break;
	
	case 'detail-rak-am-test':
	require_once('detail-rak-am-test.php');
	break;
	
	case 'detail-rak-ho':
	require_once('detail-rak-ho.php');
	break;
	
		case 'detail-rak-ho1':
	require_once('detail-rak-ho1.php');
	break;
	
	case 'setting_slik':
	require_once('setting_slik_new.php');
	break;
	
		case 'detail-rak-mos':
		require_once('detail-rak-mos.php');
		break;

	case 'detail-rak-bm-mos':
	require_once('detail-rak-bm-mos.php');
	break;

	case 'detail-rak-am-mos':
		require_once('detail-rak-am-mos.php');
		break;

	case 'detail-rak-ho-mos':
	require_once('detail-rak-ho-mos.php');
	break;

	case 'detail-form-rak-mos':
	require_once('detail-form-rak-mos.php');
	break;

	case 'tasklist_print_po':
	require_once('tasklist_print_po.php');
	break;
	
	case 'tasklist-print-po':
	require_once('tasklist-print-po.php');
	break;
	
	case 'tasklist-pengecekan-slik-cabang':
	require_once('tasklist-pengecekan-slik-cabang.php');
	break;
	
	case 'detail-rak-mos-test':
		require_once('detail-rak-mos-test.php');
		break;
	case 'detail-rak-ca-mos':
		require_once('detail-rak-ca-mos.php');
		break;
	case 'detail-rak-sbh-mos':
require_once('detail-rak-sbh-mos.php');
		break;
		
		case 'slik-detail-new':
require_once('pages/slik-detail-new.php');
		break;
	case 'slik-detail-new-pengurus':
require_once('pages/slik-detail-new-pengurus.php');
		break;
	
		case 'slik-detail-new-company':
	require_once('pages/slik-detail-new-company.php');
	break;
	
	
		case 'slik-detail-new-mapping-mix':
	require_once('pages/slik-detail-new-mapping-mix.php');
	break;
	
	case 'input-vendor-cabang-individual':
		require_once('input-vendor-cabang-individual.php');
	break;

	case 'tasklist-check-vendor':
		require_once('tasklist-check-vendor.php');
	break;	
	
	case 'approval-vendor-cabang-individual':
		require_once('approval-vendor-cabang-individual.php');
	break;

	case 'tasklist-check-inquiry-vendor':
		require_once('tasklist-check-inquiry-vendor.php');
	break;	
	
	case 'edit-vendor-cabang-individual':
		require_once('edit-vendor-cabang-individual.php');
	break;

	case 'inquiry-vendor-cabang-individual':
		require_once('inquiry-vendor-cabang-individual.php');
	break;

	case 'input-vendor-cabang-company':
		require_once('input-vendor-cabang-company.php');
	break;

	case 'approval-vendor-cabang-company':
		require_once('approval-vendor-cabang-company.php');
	break;

	
	case 'inquiry-vendor-cabang-company':
		require_once('inquiry-vendor-cabang-company.php');
	break;

	case 'edit-vendor-cabang-company':
		require_once('edit-vendor-cabang-company.php');
	break;
	
	case 'tasklist-setting-ca':
		require_once('tasklist-setting-ca.php');
	break;

	case 'detail-setting-ca':
		require_once('detail-setting-ca.php');
	break;

	case 'add-setting-ca':
		require_once('add-setting-ca.php');
	break;

	case 'delete-setting-ca':
		require_once('delete-setting-ca.php');
	break;
	
	
	case 'tasklist-loa-rak-inquiry-stg':
		require_once('tasklist-loa-rak-inquiry-stg.php');
	break;
	
	//royan testing mockup habibie 20241205
	case 'input-pelapor':
		require_once('pages/inputpelapor.php');
	break;
	
	case 'input-slik-dealer':
		require_once('input-slik-dealer.php');
	break;
	
	case 'tasklist-check-slik-dealer':
		require_once('tasklist-check-slik-dealer.php');
	break;
	case 'approval-slik-dealer':
		require_once('approval-slik-dealer.php');
	break;

	case 'tasklist-check-inquiry-slik-dealer':
		require_once('tasklist-check-inquiry-slik-dealer.php');
	break;

	case 'inquiry-slik-dealer':
		require_once('inquiry-slik-dealer.php');
	break;
	
	case 'edit-slik-dealer':
		require_once('edit-slik-dealer.php');
	break;
	
	case 'tasklist-slik-automation':
	require_once('tasklist-slik-automation.php');
	break;

	case 'tasklist-slik-automation-deb-exists':
	require_once('tasklist-slik-automation-deb-exists.php');
	break;
	
	case 'dukcapil-anomali':
		require_once('dukcapil-anomali.php');
		break;
	case 'dukcapil-anomali-detail':
		require_once('dukcapil-anomali-detail.php');
		break;
	case 'tasklist-dukcapil-anomali':
		require_once('tasklist-dukcapil-anomali.php');
		break;
	case 'tasklist-data-anomali':
		require_once('tasklist-data-anomali.php');
		break;

		break;
	case 'tasklist-dukcapil-anomali-inquiry':
		require_once('tasklist-dukcapil-anomali-inquiry.php');
		break;

	case 'dukcapil-anomali-detail-inquiry':
		require_once('dukcapil-anomali-detail-inquiry.php');
		break;

	case 'dukcapil-anomali-detail-return':
		require_once('dukcapil-anomali-detail-return.php');
		break;
		
		case 'dukcapil-anomali-detail1':
		require_once('dukcapil-anomali-detail1.php');
		break;
	case 'monitoring-debitur-menu':
		require_once('monitoring-debitur-menu.php');
		break;
	case 'slik-detail-summary':
		require_once('slik-detail-summary.php');
		break;
	case 'task_pelaporan_slik':
    	require_once('task_pelaporan_slik.php');
    	break;

	case 'task_control_pelaporan_slik':
        require_once('task_control_pelaporan_slik.php');
        break;

	case 'task_pelaporan_slik_harian':
        require_once('task_pelaporan_slik_harian.php');
        break;

	case 'task_pelaporan_slik_harian_periode':
        require_once('task_pelaporan_slik_harian_periode.php');
        break;

	case 'task_control_pelaporan_slik_harian':
        require_once('task_control_pelaporan_slik_harian.php');
        break;
	case 'cust-non-checker':
		require_once('pages/cust-non-checker.php');
		break;
	
	case 'cust-non-checker-detail':
		require_once('pages/cust-non-checker-detail.php');
		break;	

	case 'tasklist-cust-non-check':
		require_once('pages/tasklist-cust-non-check.php');
		break;

	case 'tasklist-cust-non-check-detail':
		require_once('pages/tasklist-cust-non-check-detail.php');
		break;
	
	case 'summary-slik':
		require_once('pages/summary-slik.php');
		break;

	case 'slik-detail-new':
		require_once('pages/summary-slik.php');
		break;
		
		
	case 'test_upload_pdf':
		require_once('test_upload_pdf.php');
		break;
	case 'save-clik-individu-trial':
		require_once('save-clik-individu-trial.php');
		break;

	case 'save-clik-contract-trial':
		require_once('save-clik-contract-trial.php');
		break;
	case 'save-clik-cip-trial':
		require_once('save-clik-cip-trial.php');
		break;


	case 'reader_click':
		require_once('pages/reader_click.php');
		break;


	case 'scoring-individual-click':
		require_once('scoring-individual-click.php');
		break;

	case 'individual-manual-clik':
		require_once('individual-manual-clik.php');
		break;
		
	// tasklist dukcapil - dhanis
	case 'input-cek-dukcapil':
		require_once('input-cek-dukcapil.php');
	break;

	case 'tasklist-cek-dukcapil':
		require_once('tasklist-cek-dukcapil.php');
	break;

	case 'approval-cek-dukcapil':
		require_once('approval-cek-dukcapil.php');
	break;

	case 'edit-cek-dukcapil':
		require_once('edit-cek-dukcapil.php');
	break;

	case 'history-cek-dukcapil':
		require_once('history-cek-dukcapil.php');
	break;

	case 'detail-history-cek-dukcapil':
		require_once('detail-history-cek-dukcapil.php');
	break;

	case 'view-pdf-panduan-dukcapil':
		require_once('view-pdf-panduan-dukcapil.php');
	break;
	//end
	case 'dakor-menu':	
		require_once('dakor_menu.php');
	break;
	case 'data-pelaporan-slik':	
		require_once('data-pelaporan-slik.php');
	break;
	case 'detail-rak-mos-plafond':	
		require_once('detail-rak-mos-plafond.php');
	break;
		case 'tab-click-report':	
		require_once('tab-click-report.php');
	break;

case 'detail-rak-mos_timed':
		require_once('detail-rak-mos_timed.php');
		break;
	default:
	require_once('404.php');
}

?>