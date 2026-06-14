<?php

// Clase abstracta que define un problema genérico
abstract class Problema
{
    // Método abstracto que debe implementar la clase hija
    // Debe contener la lógica para resolver el problema
    abstract public function resolver();
}