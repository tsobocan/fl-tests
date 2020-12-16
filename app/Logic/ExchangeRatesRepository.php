<?php


    namespace App\Logic;


    use App\Models\Rate;

    use Illuminate\Http\Request;
    use Box\Spout\Common\Entity\Cell;
    use Illuminate\Support\Facades\DB;
    use Box\Spout\Common\Entity\Style\Color;
    use Illuminate\Database\Eloquent\Builder;
    use Spatie\SimpleExcel\SimpleExcelWriter;
    use Dotenv\Exception\ValidationException;
    use Illuminate\Database\Eloquent\Collection;
    use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;

    class ExchangeRatesRepository
    {

        /**
         * Export monthly stats to .xlsx.
         */
        public function exportMonthlyStats()
        {
            $rates = $this->getMonthlyStats(true);

            $h_style = (new StyleBuilder())->setFontBold()->setFontSize(11)->setFontColor(Color::BLACK)->setBackgroundColor(Color::rgb(241,
                248, 255))->build();
            $m_style = (new StyleBuilder())->setFontSize(11)->setFontColor(Color::BLACK)->setFormat(Cell::TYPE_FORMULA)->build();

            $writer = SimpleExcelWriter::streamDownload('ratesByMonth.xlsx')->noHeaderRow();
            $writer->addRow(['Year/Month', 'Min', 'Max', 'Avg',], $h_style);

            foreach ($rates as $rate) {
                $writer->addRow([
                    $rate->month_year,
                    $rate->min_value,
                    $rate->max_value,
                    $rate->avg_value,
                ], $m_style);
            }
            return $writer->toBrowser();
        }

        /**
         * Returns min, max, avg, total of rates for each month.
         * @param bool $to_currency
         * @return Builder[]|Collection
         */
        public function getMonthlyStats($to_currency = false)
        {
            $rates = Rate::query()->select(DB::raw('count(id) as `total_records`'),
                DB::raw("CONCAT_WS('/',YEAR(date),MONTH(date)) as month_year"), DB::raw('MIN(value) as min_value'),
                DB::raw('MAX(value) as max_value'),
                DB::raw('AVG(value) as avg_value'))->orderBy('month_year')->groupBy('month_year')->get();

            if ($to_currency) {
                $rates = $rates->transform(function ($rate) {
                    $rate->min_value = $this->toCurrency($rate->min_value);
                    $rate->max_value = $this->toCurrency($rate->max_value);
                    $rate->avg_value = $this->toCurrency($rate->avg_value);
                    return $rate;
                });
            }

            return $rates;
        }

        /**
         *
         * Format value to currency.
         * @param $number
         * @param int $decimals
         * @param string $symbol
         * @param string $position
         * @return string
         */
        private function toCurrency($number, $decimals = 5, $symbol = '$', $position = 'before'): string
        {
            $symbol = trim($symbol);
            $start = $position == 'before' ? $symbol . ' ' : '';
            $end = $position == 'after' ? ' ' . $symbol : '';
            return $start . number_format($number, $decimals) . $end;
        }

        public function rate(Request $request){
            try{
                $request->validate([
                    'date' => 'date|nullable|date_format:Y-m-d'
                ]);

                $rate = Rate::query()->whereDate('date', $request->get('date'))->first();

                return \Response::json(['rate' => $rate]);
            }catch (\Exception $e){
                return \Response::json(['error' => $e->getMessage()]);
            }

        }
    }