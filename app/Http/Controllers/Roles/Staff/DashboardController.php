<?php

namespace App\Http\Controllers\Roles\Staff;

use App\Helper\Message as MessageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $_messageHelper;

    public function __construct(MessageHelper $messageHelper)
    {
        $this->_messageHelper = $messageHelper;

        $this->middleware('auth:staff');
    }

    public function index()
    {
        return view('roles.staff.pages.dashboard', ['welcome_message' => $this->_messageHelper->getWelcomeMessage(), 'user' => auth()->user()]);
    }
}
