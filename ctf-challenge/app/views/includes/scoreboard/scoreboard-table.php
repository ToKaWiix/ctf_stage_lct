<table>
    <thead>
        <tr>
            <th>Équipe</th>
            <th>Challenge</th>
            <th>Challenge</th>
            <th>Challenge</th>
            <th>Challenge</th>
            <th>Challenge</th>
            <th>Challenges réussis</th>
            <th>Score total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($GLOBALS['teams'] as $team): ?>
        <tr>
            <td><?php echo htmlspecialchars($team['ctf_nom_equipe']); ?></td>
            <td>🔴</td>
            <td>🟢</td>
            <td>🟣</td>
            <td>🟣</td>
            <td>🔴</td>
            <td>3</td>
            <td>650</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>