<?php

namespace App\Http\Livewire\Solicitud;

use App\Models\Endorsement;
use App\Models\Solicitud;
use App\Models\Warranty;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class SolicitudShow extends Component
{
    public Solicitud $solicitud;
    public function render()
    {
        return view('livewire.solicitud.solicitud-show', [
            'solicitud' => $this->solicitud,
        ]);
    }

    public function autorizar()
    {
        $this->solicitud->condition = 'autorizado';
        $this->solicitud->aut_den = now();
        $this->solicitud->save();
        $this->dispatchBrowserEvent('message', ['message' => 'Se autorizó  la solicitud']);
    }

    public function denegar()
    {
        $this->solicitud->condition = 'denegado';
        $this->solicitud->aut_den = now();
        $this->solicitud->save();
        $this->dispatchBrowserEvent('message', ['message' => 'Se denegó la solicitud']);
    }
    /* Quit endorsement, but not delete */
    public function quitEndorsement(Endorsement $endorsement)
    {
        $this->solicitud->endorsements()->detach($endorsement);
        $this->solicitud->refresh();
        $this->dispatchBrowserEvent('message', ['message' => 'Se ha desvinculado con el aval']);
    }
    /* Destroy warranty */
    public function destroyWarranty(Warranty $warranty)
    {
        if ($warranty->url_document) {
            if (Storage::disk('public')->exists($warranty->url_document)) {
                Storage::disk('public')->delete($warranty->url_document);
            }
        }
        $warranty->delete();
        $this->solicitud->refresh();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó la garantía']);
    }

    public function exportPDF()
    {
        $data = [
            'solicitud' => $this->solicitud,
            'partner' => $this->solicitud->partner,
        ];
        $pdf = Pdf::loadView('pdf-template.solicitud-prestamo', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-solicitud_' . $this->solicitud->folio . '.pdf');
    }

    public function exportWord()
    {
        // Crear un objeto de PHPWord
        $phpWord = new PhpWord();

        // Agregar una sección al documento
        $section = $phpWord->addSection();
        $data = [
            'solicitud' => $this->solicitud,
            'partner' => $this->solicitud->partner,
        ];
        // Obtener la vista de Laravel como HTML
        $html = view('pdf-template.prueba-word', $data)->render();

        // Agregar el HTML como contenido al documento de Word
        $section->addHtml($html);

        // Guardar el documento de Word en un archivo temporal
        $temp_file = tempnam(sys_get_temp_dir(), 'word');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($temp_file);

        // Descargar el archivo
        $response = new Response();
        $response->setContent(file_get_contents($temp_file));
        $response->header('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $response->header('Content-Disposition', 'attachment;filename=documento.docx');
        $response->header('Content-Length', filesize($temp_file));
        unlink($temp_file);
        return $response;
    }
}
