<?php
declare(strict_types=1);
function canComplete(array $session, int $requestedEventId, int $now, int $ttl): bool {
    if ($ttl <= 0) { return false; }
    if (!isset($session['draft']) || !is_array($session['draft'])) { return false; }
    $draft = $session['draft'];
    if (!isset($draft['data']) || !is_array($draft['data'])) { return false; }
    if (!isset($draft['data']['event_id']) || !is_int($draft['data']['event_id'])) { return false; }
    if (!isset($draft['created_at']) || !is_int($draft['created_at'])) { return false; }
    if ($draft['data']['event_id'] !== $requestedEventId) { return false; }
    $createdAt = $draft['created_at'];
    if ($createdAt > $now) { return false; }
    return ($now - $createdAt) < $ttl;
}