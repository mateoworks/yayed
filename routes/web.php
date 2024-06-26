<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Helpers\AutocompleteController;
use App\Http\Controllers\Helpers\ExportController;
use App\Http\Controllers\Helpers\SearchController;
use App\Http\Livewire\Colonia\ColoniasForm;
use App\Http\Livewire\Colonia\ColoniasList;
use App\Http\Livewire\Config\Backup;
use App\Http\Livewire\Config\ConfigForm;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Endorsement\EndorsementsForm;
use App\Http\Livewire\Endorsement\EndorsementsList;
use App\Http\Livewire\Endorsement\EndorsementsShow;
use App\Http\Livewire\Job\JobsForm;
use App\Http\Livewire\Job\JobsList;
use App\Http\Livewire\Loan\LoanAmortizacion;
use App\Http\Livewire\Loan\LoanPaymentPlan;
use App\Http\Livewire\Loan\LoansContract;
use App\Http\Livewire\Loan\LoansDetail;
use App\Http\Livewire\Loan\LoansEdit;
use App\Http\Livewire\Loan\LoansForm;
use App\Http\Livewire\Loan\LoansList;
use App\Http\Livewire\Loan\LoansPartnerForm;
use App\Http\Livewire\Loan\LoansShow;
use App\Http\Livewire\Loan\LoansVencido;
use App\Http\Livewire\Movement\MovementsForm;
use App\Http\Livewire\Movement\MovementsList;
use App\Http\Livewire\Partner\PartnersForm;
use App\Http\Livewire\Partner\PartnersList;
use App\Http\Livewire\Partner\PartnersShow;
use App\Http\Livewire\Payments\PaymentForm;
use App\Http\Livewire\Payments\PaymentList;
use App\Http\Livewire\Payments\PaymentShow;
use App\Http\Livewire\Report\ExportTable;
use App\Http\Livewire\Report\ReportSemanal;
use App\Http\Livewire\Report\ReportSimple;
use App\Http\Livewire\Solicitud\SolicitudEdit;
use App\Http\Livewire\Solicitud\SolicitudForm;
use App\Http\Livewire\Solicitud\SolicitudList;
use App\Http\Livewire\Solicitud\SolicitudShow;
use App\Http\Livewire\User\Profile;
use App\Http\Livewire\User\ProfileEdit;
use App\Http\Livewire\User\UsersForm;
use App\Http\Livewire\User\UsersList;
use App\Http\Livewire\User\UsersShow;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', Dashboard::class)->name('dashboard');

    Route::get('profile', Profile::class)->name('profile');
    Route::get('profile/edit', ProfileEdit::class)->name('profile.edit');

    Route::get('movimientos', MovementsList::class)->name('movements.index');
    Route::get('movimientos/create', MovementsForm::class)->name('movements.create');
    Route::get('movimientos/edit/{movement}', MovementsForm::class)->name('movements.edit');

    Route::get('users', UsersList::class)->name('users.index');
    Route::get('users/view/{user}', UsersShow::class)->name('users.show');
    Route::get('users/create/', UsersForm::class)->name('users.create');
    Route::get('users/edit/{user}', UsersForm::class)->name('users.edit');

    Route::get('partners', PartnersList::class)->name('partners.index');
    Route::get('partners/create/', PartnersForm::class)->name('partners.create');
    Route::get('partners/edit/{partner}', PartnersForm::class)->name('partners.edit');
    Route::get('partners/show/{partner}', PartnersShow::class)->name('partners.show');

    Route::get('solicitud/create/{partner}', SolicitudForm::class)->name('partners.solicitud.create');
    Route::get('solicitud/show/{solicitud}', SolicitudShow::class)->name('partners.solicitud.show');
    Route::get('solicitud', SolicitudList::class)->name('solicitud.index');
    Route::get('solicitud/edit/{solicitud}', SolicitudEdit::class)->name('solicitud.edit');

    Route::get('documents/download/{document}', [DocumentController::class, 'download'])->name('documents.download');

    Route::get('loans', LoansList::class)->name('loans.index');
    Route::get('loans/create', LoansForm::class)->name('loans.create');
    Route::get('loans/edit/{loan}', LoansEdit::class)->name('loans.edit');
    Route::get('loans/partner/{solicitud}', LoansPartnerForm::class)->name('loans.solicitud');
    Route::get('loans/show/{loan}', LoansShow::class)->name('loans.show');
    Route::get('loans/detail/{loan}', LoansDetail::class)->name('loans.detail');
    Route::get('loans/contract/{loan}', LoansContract::class)->name('loans.contract');
    Route::get('loans/plan/{loan}', LoanPaymentPlan::class)->name('loans.payment.plan');
    Route::get('loans/amortizacion/{loan}', LoanAmortizacion::class)->name('loans.amortizacion');
    Route::get('loans/vencidos', LoansVencido::class)->name('loans.vencidos');

    Route::get('payments', PaymentList::class)->name('payments.index');
    Route::get('payments/edit/{loan}', PaymentForm::class)->name('payments.edit');
    Route::get('payments/show/{payment}', PaymentShow::class)->name('payments.show');
    Route::get('payments/create/{loan}', PaymentForm::class)->name('payments.create');

    Route::get('endorsements', EndorsementsList::class)->name('endorsements.index');
    Route::get('endorsements/show/{endorsement}', EndorsementsShow::class)->name('endorsements.show');
    Route::get('endorsements/create', EndorsementsForm::class)->name('endorsements.create');
    Route::get('endorsements/edit/{endorsement}', EndorsementsForm::class)->name('endorsements.edit');

    Route::get('utilidades/jobs', JobsList::class)->name('job.index');
    Route::get('utilidades/jobs/create', JobsForm::class)->name('job.create');
    Route::get('utilidades/jobs/edit/{job}', JobsForm::class)->name('job.edit');
    Route::get('utilidades/colonias', ColoniasList::class)->name('colonia.index');
    Route::get('utilidades/colonias/create', ColoniasForm::class)->name('colonia.create');
    Route::get('utilidades/colonias/edit/{colonia}', ColoniasForm::class)->name('colonia.edit');
    Route::get('utilidades/config', ConfigForm::class)->name('config');
    Route::get('utilidades/backup', Backup::class)->name('backup');

    Route::get('warranties/download/{warranty}', [DocumentController::class, 'downloadWarranty'])
        ->name('warranties.download');

    Route::get('endorsements/autocomplete', [AutocompleteController::class, 'endorsements'])
        ->name('endorsements.autocomplete');
    Route::get('search', SearchController::class)->name('search');

    Route::get('loans/export/excel', [ExportController::class, 'loansExportExcel'])->name('loans.export.excel');
    Route::get('loans/amortizacion/excel/{amortizacion}', [ExportController::class, 'amortizacionExportExcel'])
        ->name('loans.amortizacion.excel');



    Route::get('reporte/mensual', ReportSimple::class)->name('report.simple');
    Route::get('reporte/semanal', ReportSemanal::class)->name('report.semanal');
    Route::get('reporte/exportar', ExportTable::class)->name('report.export');

    Route::view('prueba/pdf', 'pdf-template.contrato-prestamo');
});
