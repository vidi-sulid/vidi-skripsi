<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Models\Master\Member;
use App\Models\Transaksi\Journal;
use App\Models\Transaksi\SavingMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    function show()
    {

        $date = date('Y-m-d');
        $data = Template::get();
        array_push($data['pilihCss'],  "chart",  "apex-charts", "card-analytics");
        array_push($data['pilihJs'],   "chart");
        $data['jsTambahan'] = "
        $('#dashboards').addClass('open active');
        ";
        $data['lastWeek'] = date('Y-m-d', strtotime('-1 week'));
        $data['members'] = number_format(Member::where('status', '=', 1)->count());
        $data['membersLastWeek'] = number_format(Member::where('date', '<=', $data['lastWeek'])->count());
        $data['memberGrowth'] = Round(100 - ($data['membersLastWeek'] / $data['members']) * 100, 2);
        $data['memberText'] = 'text-success';
        $data['memberIcon'] = 'bx-up-arrow-alt';
        if ($data['memberGrowth'] < 0) {
            $data['memberText'] = 'text-danger';
            $data['memberIcon'] = 'bx-down-arrow-alt';
        }
        for ($x = -6; $x <= 0; $x++) {
            $time = strtotime("$x day");
            $day  = date('Y-m-d', $time);
            $daily[] = substr(date('D', $time), 0, 1);
            $memberDaily[] = number_format(Member::where('date', '=', $day)->count());
        }
        $data['daily'] = json_encode($daily);
        $data['memberDaily'] = json_encode($memberDaily);
        $data['last10Days'] = date('Y-m-d', strtotime('-9 days'));
        $data['mutationDeposit'] = SavingMutation::where('date', '>=', $data['last10Days'])->count();
        $data['mutationDepositDaily'] = SavingMutation::where('date', '=', $date)->count();
        for ($x = -9; $x <= 0; $x++) {
            $time = strtotime("$x day");
            $day = date('Y-m-d', $time);
            $dateMutation[] = date('m-d', $time);
            $mutationDaily[] = number_format(SavingMutation::where('date', '=', $day)->count());
        }
        $data['dateMutation'] = json_encode($dateMutation);
        $data['mutationDaily'] = json_encode($mutationDaily);
        $data['cashBalance'] = Journal::where('rekening', 'like', '1.100%')

            ->sum(DB::raw('(debit - credit)'));
        $data['cashDaily'] = Journal::where('rekening', 'like', '1.100%')

            ->where('date', '=', $date)
            ->sum(DB::raw('(debit - credit)'));
        $data['cashText'] = 'text-success';
        $data['cashIcon'] = 'bx-up-arrow-alt';
        if ($data['cashDaily'] < 0) {
            $data['cashText'] = 'text-danger';
            $data['cashIcon'] = 'bx-down-arrow-alt';
        }
        $data['assetBalance'] = Journal::where('rekening', 'like', '1%')

            ->sum(DB::raw('(debit - credit)'));
        $dateAssetEnd = date('Y-m-t', strtotime("-4 month", strtotime(date('Y-m-01'))));
        $assetEnd = Journal::where('rekening', 'like', '1%')

            ->where('date', '<=', $dateAssetEnd)
            ->sum(DB::raw('(debit - credit)'));
        for ($x = -3; $x <= 0; $x++) {
            $time = strtotime("$x month", strtotime(date('Y-m-01')));
            $eom = date('Y-m-t', $time);
            $dateAsset[] = date('M', $time);
            $assetMonthlyStart[] = $assetEnd;
            $assetEnd = Journal::where('rekening', 'like', '1%')

                ->where('date', '<=', $eom)
                ->sum(DB::raw('(debit - credit)'));
            $assetMonthlyEnd[] = $assetEnd;
        }
        $data['dateAsset'] = json_encode($dateAsset);
        $data['assetMonthlyStart'] = json_encode($assetMonthlyStart);
        $data['assetMonthlyEnd'] = json_encode($assetMonthlyEnd);
        $data['incomeBalance'] = Journal::where('rekening', 'like', '4%')

            ->sum(DB::raw('(credit - debit)'));
        $data['incomeDaily'] = Journal::where('rekening', 'like', '4%')

            ->where('date', '=', $date)
            ->sum(DB::raw('(credit - debit)'));
        $data['costBalance'] = Journal::where('rekening', 'like', '5%')

            ->sum(DB::raw('(debit - credit)'));
        $data['costDaily'] = Journal::where('rekening', 'like', '5%')

            ->where('date', '=', $date)
            ->sum(DB::raw('(debit - credit)'));
        $data['profitBalance'] = $data['incomeBalance'] - $data['costBalance'];
        $data['profitDaily'] = $data['incomeDaily'] - $data['costDaily'];
        for ($x = -11; $x <= 0; $x++) {
            $time = strtotime("$x month", strtotime(date('Y-m-01')));
            $bom = date('Y-m-01', $time);
            $eom = date('Y-m-t', $time);
            $dateProfit[] = date('Y-m', $time);
            $income = Journal::where('rekening', 'like', '4%')

                ->whereBetween('date', [$bom, $eom])
                ->sum(DB::raw('(credit - debit)'));
            $cost = Journal::where('rekening', 'like', '5%')

                ->whereBetween('date', [$bom, $eom])
                ->sum(DB::raw('(debit - credit)'));
            $profitMonthly[] = $income - $cost;
        }
        $data['averageProfit'] = array_sum($profitMonthly) / count($profitMonthly);
        $data['dateProfit'] = json_encode($dateProfit);
        $data['profitMonthly'] = json_encode($profitMonthly);
        return view("home", $data);
    }

    function backup()
    {
        abort_if(Gate::denies('backup_update'), 403);

        $files = Storage::files('public/Koperasi');
        $data = Template::get();
        $data['pathBackup'] = array();
        foreach ($files as $file) {
            $fileName = basename($file);
            // Generate the URL to download the file
            $url = Storage::url($file);

            $data['pathBackup'][] = [
                'text' => $fileName,
                'type' => 'database',
                'a_attr' => array("href" => asset("storage/Koperasi/" . $fileName))
            ];
        }
        $data['jsTambahan'] = "
        $('#backup').addClass('open active');
        ";
        return view("user.backup", $data);
    }

    public function versi()
    {
        $projectRoot = base_path();
        chdir($projectRoot);
        $output = shell_exec('git log');

        $commits = [];

        $lines = explode("\n", $output);
        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }

            if (strpos($line, 'commit') === 0) {
                $commitHash = trim(substr($line, 6));
                $commitMessage = '';
                $author = ''; // Initialize author variable
            } else if (strpos($line, 'Author:') === 0) {
                $author = trim(substr($line, 7)); // Extract author name (excluding "Author: ")
            } else if (strpos($line, 'Date:') === 0) {
                $commitDate = trim(substr($line, 5));
            } else {
                $commitMessage .= $line . "\n";
            }

            if (!empty($commitHash) && !empty($commitMessage) && !empty($commitDate) && !empty($author)) {
                $commits[] = [
                    'hash' => $commitHash,
                    'message' => trim($commitMessage),
                    'date' => $commitDate,
                    'author' => $author, // Add author to the array
                ];

                $commitHash = '';
                $commitMessage = '';
                $commitDate = '';
                $author = ''; // Reset author for next commit
            }
        }
        $data = Template::get();
        $data['update'] = $commits;
        $data['jsTambahan'] = "
        $('#versi').addClass('open active');
        ";
        return view("user.versi", $data);
    }
}
