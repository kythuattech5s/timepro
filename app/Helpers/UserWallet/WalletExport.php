<?php
namespace App\Helpers\UserWallet;
use App\Models\UserWalletTransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class WalletExport implements FromView, WithEvents, ShouldAutoSize
{
    use RegistersEventListeners;
    public function view(): View
    {
        $time = request()->input('time');
        $transactions = UserWalletTransaction::where('user)id', \Auth::id())->orderBy('id', 'DESC')->get();
        return view('auth.account.export_wallet', compact('transactions'));
    }
    public static function afterSheet(AfterSheet $event)
    {
        \Support::settingExcel($event);
    }
}
