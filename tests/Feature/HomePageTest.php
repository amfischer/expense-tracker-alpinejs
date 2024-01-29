<?php

it('can render the homepage', function () {
    $this->get('/')->assertSee('Documentation');
});
