<div id="config-dashboard">
    <div id="config-title">
        <h2>Configuration</h2>
    </div>
    <div id="card-add-admin">
        <div id="card-add-admin-content">
            <h3>Ajout administrateur</h3>
            <div id="add-admin-form">
                <form action="/create.php" method="post">
                    <label for="username">Identifiant :</label>
                    <input type="text" id="username" name="username" required>
                    <label for="username">Mot de passe :</label>
                    <input type="text" id="username" name="username" required>
                    <div id="submit-login-button">
                        <button type="submit">Ajouter l'administrateur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="card-list-admin">
        <div id="list-admin-title">
            <h3>Liste des administrateurs</h3>
        </div>
        <div id="list-admin-content">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Identifiant</th>
                            <th>Mot de passe</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>admin1</td>
                            <td>******************</td>
                            <td id="actions-icons">
                                <svg width="30" height="30" viewBox="0 0 44 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.66699 3.58398L30.2503 9.85482L33.0003 23.2923L23.8337 32.2507L10.0837 29.5632L3.66699 3.58398ZM3.66699 3.58398L17.5747 17.1756M22.0003 34.0423L34.8337 21.5007L40.3337 26.8757L27.5003 39.4173L22.0003 34.0423ZM23.8337 19.709C23.8337 21.688 22.192 23.2923 20.167 23.2923C18.1419 23.2923 16.5003 21.688 16.5003 19.709C16.5003 17.73 18.1419 16.1257 20.167 16.1257C22.192 16.1257 23.8337 17.73 23.8337 19.709Z" stroke="#007AFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg width="30" height="30" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" stroke="#C00F0C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td>admin2</td>
                            <td>******************</td>
                            <td id="actions-icons">
                                <svg width="30" height="30" viewBox="0 0 44 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.66699 3.58398L30.2503 9.85482L33.0003 23.2923L23.8337 32.2507L10.0837 29.5632L3.66699 3.58398ZM3.66699 3.58398L17.5747 17.1756M22.0003 34.0423L34.8337 21.5007L40.3337 26.8757L27.5003 39.4173L22.0003 34.0423ZM23.8337 19.709C23.8337 21.688 22.192 23.2923 20.167 23.2923C18.1419 23.2923 16.5003 21.688 16.5003 19.709C16.5003 17.73 18.1419 16.1257 20.167 16.1257C22.192 16.1257 23.8337 17.73 23.8337 19.709Z" stroke="#007AFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg width="30" height="30" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" stroke="#C00F0C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td>admin3</td>
                            <td>******************</td>
                            <td id="actions-icons">
                                <svg width="30" height="30" viewBox="0 0 44 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.66699 3.58398L30.2503 9.85482L33.0003 23.2923L23.8337 32.2507L10.0837 29.5632L3.66699 3.58398ZM3.66699 3.58398L17.5747 17.1756M22.0003 34.0423L34.8337 21.5007L40.3337 26.8757L27.5003 39.4173L22.0003 34.0423ZM23.8337 19.709C23.8337 21.688 22.192 23.2923 20.167 23.2923C18.1419 23.2923 16.5003 21.688 16.5003 19.709C16.5003 17.73 18.1419 16.1257 20.167 16.1257C22.192 16.1257 23.8337 17.73 23.8337 19.709Z" stroke="#007AFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg width="30" height="30" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" stroke="#C00F0C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td>admin4</td>
                            <td>******************</td>
                            <td id="actions-icons">
                                <svg width="30" height="30" viewBox="0 0 44 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.66699 3.58398L30.2503 9.85482L33.0003 23.2923L23.8337 32.2507L10.0837 29.5632L3.66699 3.58398ZM3.66699 3.58398L17.5747 17.1756M22.0003 34.0423L34.8337 21.5007L40.3337 26.8757L27.5003 39.4173L22.0003 34.0423ZM23.8337 19.709C23.8337 21.688 22.192 23.2923 20.167 23.2923C18.1419 23.2923 16.5003 21.688 16.5003 19.709C16.5003 17.73 18.1419 16.1257 20.167 16.1257C22.192 16.1257 23.8337 17.73 23.8337 19.709Z" stroke="#007AFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg width="30" height="30" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" stroke="#C00F0C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </td>
                        </tr>
                        <tr>
                            <td>admin5</td>
                            <td>******************</td>
                            <td id="actions-icons">
                                <svg width="30" height="30" viewBox="0 0 44 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.66699 3.58398L30.2503 9.85482L33.0003 23.2923L23.8337 32.2507L10.0837 29.5632L3.66699 3.58398ZM3.66699 3.58398L17.5747 17.1756M22.0003 34.0423L34.8337 21.5007L40.3337 26.8757L27.5003 39.4173L22.0003 34.0423ZM23.8337 19.709C23.8337 21.688 22.192 23.2923 20.167 23.2923C18.1419 23.2923 16.5003 21.688 16.5003 19.709C16.5003 17.73 18.1419 16.1257 20.167 16.1257C22.192 16.1257 23.8337 17.73 23.8337 19.709Z" stroke="#007AFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg width="30" height="30" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" stroke="#C00F0C" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="card-time-ctf">
        <div id="ctf-time-title">
            <h3>Durée du CTF</h3>
        </div>
        <form action="/start-ctf.php" method="post" id="ctf-time-form">
            <div class="ctf-time-row">
                <label for="start-time">Début du CTF :</label>
                <input type="datetime-local" id="start-time" name="start-time" required>
            </div>
            <div class="ctf-time-row">
                <label for="end-time">Fin du CTF :</label>
                <input type="datetime-local" id="end-time" name="end-time" required>
            </div>
            <div class="ctf-time-btn-row">
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>
    <div id="card-time-prison">
        <div id="prison-time-title">
            <h3>Temps passé en prison</h3>
        </div>
        <form action="/prison-time.php" method="post" id="prison-time-form">
            <div class="prison-time-row">
                <label for="prison-time">Temps passé en prison :</label>
                <input type="datetime-local" id="prison-time" name="prison-time" required>
            </div>
            <div class="prison-time-btn-row">
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>
    <div id="card-partenaires">
        <div id="list-admin-title">
            <h3>Partenaires</h3>
        </div>
    </div>
    <div id="card-give-pts">
        <div id="list-admin-title">
            <h3>Attribuer les points</h3>
        </div>
    </div>
</div>