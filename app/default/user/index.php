<?php

if (empty($_USER)) {
    move_to(DEFAULT_URL."user/login");
} else {
    move_to(HOME_URL."user/profile");
}