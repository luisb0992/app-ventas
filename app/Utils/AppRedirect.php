<?php

/**
 * Gestiona todas las formas de redirecciones de la app
 *
 * @author  luisbardev <luisbardev@gmail.com> luisbardev.com
 */

namespace App\Utils;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AppRedirect
{

  /**
   * Redirecciona a una ruta indicada junto a un mensaje de error
   * pasado por una variable de session
   *
   * @param  String $route    La ruta a la que redireccionar
   * @param  String $key      El nombre de la variable de session
   * @param  String $message  El mensaje
   * @return RedirectResponse  La redirección
   */
  public static function withSession(string $route, string $key, string $message): RedirectResponse
  {
    // crea o sobrescribe la variable de session
    self::createProperty($key, $message);

    // Redirecciona a la ruta indicada
    return self::to($route);
  }

  /**
   * Redirecciona y Olvida una propiedad de session
   *
   * @param  String $route      La ruta a la que redireccionar
   * @param  String $key        El nombre de la propiedad
   * @return RedirectResponse   La redirección
   */
  public static function forgettingProperty(string $route, string $key): RedirectResponse
  {
    // olvida la propiedad de session
    self::forgetProperty($key);

    // Redirecciona a la ruta indicada
    return self::to($route);
  }

  /**
   * Elimina una variable de session
   *
   * @param string $key     El nombre de la propiedad
   * @return void
   */
  public static function forgetProperty(string $key): void
  {
    // olvida la propiedad de session
    session()->forget($key);
  }

  /**
   * Elimina una variable de session
   *
   * @param string $key       El nombre de la propiedad
   * @param string $message   El mensaje
   * @return void
   */
  public static function createProperty(string $key, string $message): void
  {
    // olvida la propiedad de session
    session()->put($key, $message);
  }

  /**
   * Redirecciona a una ruta indicada
   *
   * @param  String $route      La ruta a la que redireccionar
   * @return RedirectResponse   La redirección
   */
  public static function to(string $route): RedirectResponse
  {
    return redirect($route);
  }

  /**
   * Devuelve una respuesta del tipo inertia
   *
   * @param string $component   El nombre del componente
   * @param array $data         Los datos a pasar al componente
   * @param string $key|null    El nombre de la variable de session
   * @return Response           La redirección del tipo inertia
   */
  public static function inertiaRender(string $component, array $data = [], string $key = ''): Response
  {
    // en caso de existir una propiedad o variable de session
    // esta sera eliminada
    if ($key) {
      self::forgetProperty($key);
    }

    // la redirección al componente de inertia
    return Inertia::render($component, $data);
  }
}
