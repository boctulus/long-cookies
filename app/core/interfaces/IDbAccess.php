<?php

namespace boctulus\TolScraper\core\interfaces;

interface IDbAccess {
    public function getDbAccess($user_id);
    public function hasDbAccess($user_id, string $db_connection);
}
