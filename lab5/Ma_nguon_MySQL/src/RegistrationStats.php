<?php

declare(strict_types=1);
require_once __DIR__ . '/Database.php';
function registrationStats(mysqli $connection, int $eventId): array
{
    $sql = 'SELECT e.id AS event_id, e.title AS title, COUNT(r.id) AS total
            FROM events e
            LEFT JOIN registrations r ON r.event_id = e.id
            WHERE e.id = ?
            GROUP BY e.id, e.title';

    $stmt = queryParams($connection, $sql, [$eventId]);
    $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if ($rows === []) {
        return [];   
    }
    return [
        'event_id' => (int)$rows[0]['event_id'],
        'title'    => (string)$rows[0]['title'],
        'total'    => (int)$rows[0]['total'],
    ];
}
