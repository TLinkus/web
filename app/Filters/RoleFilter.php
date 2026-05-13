<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session('user_id')) {
            return redirect()->to('/login')->with('error', 'Prisijunkite, kad galėtumėte tęsti.');
        }

        if ($arguments && ! in_array(session('role'), $arguments, true)) {
            return redirect()->to('/dashboard')->with('error', 'Neturite teisės atlikti šio veiksmo.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
