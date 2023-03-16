<?php

namespace App\Providers;

use App\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Spatie\Translatable\Facades\Translatable;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Writer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Date::use(
            Carbon::class
        );

        // excel config
        Sheet::macro(
            'styleCells',
            function (
                Sheet $sheet,
                string $cellRange,
                array $style
            ) {
                $sheet
                    ->getDelegate()
                    ->getStyle($cellRange)
                    ->applyFromArray($style);
            }
        );
        Sheet::macro(
            'setAutofilter',
            function (
                Sheet $sheet,
                $cellRange
            ) {
                $sheet->getDelegate()
                      ->setAutoFilter($cellRange);
            }
        );
        Writer::listen(
            BeforeExport::class,
            function () {
            }
        );
        Writer::listen(
            BeforeWriting::class,
            function () {
            }
        );
        Sheet::listen(
            BeforeSheet::class,
            function () {
            }
        );
        Sheet::listen(
            AfterSheet::class,
            function ($event) {
                $event->sheet->freezePane('A2');
                $event->sheet->setAutofilter(
                    $event->sheet->calculateWorksheetDimension()
                );
                $event->sheet->styleCells(
                    'A1:'.$event->sheet->getHighestColumn().'1',
                    [
                        'font' => [
                            'bold' => true,
                        ],
                    ]
                );
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(app()->environment('local'));

        Stringable::macro('initials', function () {
            $words = preg_split("/\s+/", $this);
            $initials = '';

            foreach ($words as $w) {
                $initials .= $w[0];
            }

            return new static($initials);
        });
        Str::macro('initials', function (string $string) {
            return (string) (new Stringable($string))->initials();
        });

        Translatable::fallback(
            fallbackAny: true,
        );
    }
}
