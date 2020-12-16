<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Logic\ExchangeRatesApi;
    use App\Logic\ExchangeRatesRepository;

    class HomeController extends Controller
    {

        protected function index()
        {
            return view('welcome');
        }

        protected function report()
        {
            $rates = (new ExchangeRatesRepository)->getMonthlyStats();

            return view('report', ['rates' => $rates]);
        }

        protected function fetchRatesFromApi(Request $request)
        {
            $status = (new ExchangeRatesApi())->fetchRates();

            $response = [
                'status' => !$status ? 500 : 200,
                'message' => !$status ? 'Something went wrong. Please try again.' : 'Exchange rates saved.'
            ];

            if ($request->isJson()) {
                return response()->json($response);
            }

            return view('welcome', $response);
        }

        protected function export()
        {
            (new ExchangeRatesRepository)->exportMonthlyStats();
        }
    }
