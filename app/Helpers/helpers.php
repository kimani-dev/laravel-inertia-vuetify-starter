<?php

function sendFlashMessage(string $type, string $message) {
    session()->flash('type', $type);
    session()->flash('message', $message);
}