<?php

/**
 * Trait BDTrait
 *
 * Gestiona todas las funcionalidades respecto a la base de datos
 * - crear tablas
 * - crear datos
 * - eliminar tablas
 * - eliminar datos
 * - actualizar tablas
 * - actualizar datos
 * - consultar datos
 * - consultar tablas
 * - consultar datos de una tabla de usuario
 * - etc
 *
 * @author luisbardev <luisbardev@gmail.com> <luisbardev.com>
 */

namespace App\Http\Traits\User;

use App\Models\User;

trait BDTrait
{
  /**
   * Actualiza los datos de un usuario
   *
   * @param User $user      El usuario a actualizar
   * @param array $data     Los datos a actualizar
   * @return boolean        Si se actualizó o no
   */
  public function updateData(User $user, array $data): bool
  {
    return $user->update($data);
  }
}
