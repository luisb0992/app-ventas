<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordProfile;
use App\Http\Requests\UpdateProfile;
use App\Http\Traits\User\BDTrait;
use App\Http\Traits\User\UtilTrait;
use App\Models\User;
use App\Utils\AppRedirect;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class UserController extends Controller
{

    /**
     * Utilidades extras para el usuario
     */
    use UtilTrait;

    /**
     * Funcionalidades de BD
     */
    use BDTrait;

    /**
     * Devuelve la vista para manipular el perfil del usuario
     *
     * @return Response         La vista del componente
     */
    public function profile(): Response
    {
        return AppRedirect::inertiaRender('User/Profile');
    }

    /**
     * Actualiza los datos del usuario menos la contraseña
     *
     * @param UpdateProfile $request        Los datos del usuario
     * @param User $user                    El usuario a actualizar
     * @return Response                     La vista del componente
     */
    public function updateProfile(UpdateProfile $request, User $user): RedirectResponse
    {
        // $user->update($request->only(['name', 'lastname', 'user']));
        $this->updateData($user, $request->only(['name', 'lastname', 'user']));
        return AppRedirect::to(route('profile'));
    }

    /**
     * Actualiza la contraseña del usuario
     *
     * @param UpdateProfile $request        Los datos del usuario
     * @param User $user                    El usuario a actualizar
     * @return Response                     La vista del componente
     */
    public function updateProfilePassword(UpdatePasswordProfile $request, User $user): RedirectResponse
    {
        $pass = $this->encryptPassword($request->password);
        $this->updateData($user, ['password' => $pass]);
        return AppRedirect::to(route('profile'));
    }
}
