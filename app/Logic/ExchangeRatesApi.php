<?php


    namespace App\Logic;


    use Carbon\Carbon;
    use App\Models\Rate;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Http;

    class ExchangeRatesApi
    {
        private $base = 'EUR';
        private $start = '2020-01-01';
        private $end = '2020-12-31';
        private $symbols = 'USD';
        private $url;
        private $from;
        private $to;

        public function __construct($from = null, $to = null)
        {
            $this->from = $from ?? $this->start;
            $this->to = $to ?? $this->end;
            $this->url = "https://api.exchangeratesapi.io/history?base={$this->base}&start_at={$this->start}&end_at={$this->end}&symbols={$this->symbols}";
        }

        /**
         * Side comment: I am using Http as it is built in. We can do this using file_get_contents...
         */
        public function fetchRates(): bool
        {
            try {
                $rates = Http::get($this->url)->json();
                return $this->saveRates($rates);
            } catch (\Exception $e) {
                Log::alert('Updating rates data error: ' . $e->getMessage());
            }
            return false;
        }

        private function saveRates(array $rates): bool
        {
            $base = $rates['base'];
            foreach ($rates['rates'] as $date => $data) {
                $symbol = array_key_first($data);
                Rate::query()->updateOrCreate(['date' => $date, 'base' => $base, 'symbol' => $symbol],
                    ['value' => $data[$symbol]]);
            }

            return true;
        }

    }