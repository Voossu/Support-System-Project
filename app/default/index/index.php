<?php

if (empty($_USER)) {
    move_to(HOME_URL."user/login");
} else {
    move_to(HOME_URL."requests");
}