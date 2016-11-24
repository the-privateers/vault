<?php

namespace Vault\Http\Controllers;

use Illuminate\Http\Request;
use Vault\Lockers\LockerRepository;
use Vault\Secrets\SecretRepository;

class SecretController extends Controller
{

    /**
     * @var SecretRepository
     */
    private $secretRepository;

    /**
     * SecretController constructor.
     * @param SecretRepository $secretRepository
     */
    public function __construct(SecretRepository $secretRepository)
    {
        $this->secretRepository = $secretRepository;
    }

    public function update(Request $request)
    {
        $this->secretRepository->update($request->get('lockbox'), $request->get('secrets'));

        flash()->success('Secrets updated');

        return redirect()->back();
    }
}
