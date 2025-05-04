<?php
function conecta_mysql() {
    return new mysqli("db", "furia", "furia123", "furia_chat");
}