<?php

/**
 * Trait UtilTrait
 *
 * Gestiona todas las utilidades extras que puede necesitar el usuario
 * - encriptar contraseña
 * - generar token
 * - generar código de verificación
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 */

namespace App\Http\Traits\User;


trait UtilTrait
{
  /**
   * Devuelve una contraseña encriptada
   *
   * @param string $password    La contraseña a encriptar
   * @return string             La contraseña encriptada
   */
  public function encryptPassword(string $password): string
  {
    return bcrypt($password);
  }
}
