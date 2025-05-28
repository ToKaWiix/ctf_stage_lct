<div id="player-dashboard">
    <div id="player-list-title">
        <h2>Gestion des joueurs</h2>
    </div>
    <div id="card-player-list">
        <div id="card-player-list-content">
            <h3>Liste des joueurs par équipe</h3>
            <div id="player-list-table">
                <button class="accordion">Équipe 1 :</button>
                <div class="panel">
                    <table>
                        <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Surnom</th>
                                <th>Photo</th>
                                <th>En prison</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Léa</td>
                                <td>Martin</td>
                                <td>LeaM</td>
                                <td><img src="/ctf_anna/ctf-challenge/public/images/avatar1.jpg" alt="Léa" style="width:40px;height:40px;border-radius:50%;"></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="prison_lea" />
                                        <span class="slider"></span>
                                    </label>
                                </td>
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
                                <td>Thomas</td>
                                <td>Dubois</td>
                                <td>TomD</td>
                                <td><img src="/ctf_anna/ctf-challenge/public/images/avatar2.jpg" alt="Thomas" style="width:40px;height:40px;border-radius:50%;"></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="prison_thomas" />
                                        <span class="slider"></span>
                                    </label>
                                </td>
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
                <button class="accordion">Équipe 2 :</button>
                <div class="panel">
                    <table>
                        <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Surnom</th>
                                <th>Photo</th>
                                <th>En prison</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Emma</td>
                                <td>Leroy</td>
                                <td>EmL</td>
                                <td><img src="/ctf_anna/ctf-challenge/public/images/avatar3.jpg" alt="Emma" style="width:40px;height:40px;border-radius:50%;"></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="prison_emma" />
                                        <span class="slider"></span>
                                    </label>
                                </td>
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
                                <td>Lucas</td>
                                <td>Bernard</td>
                                <td>LBern</td>
                                <td><img src="/ctf_anna/ctf-challenge/public/images/avatar4.jpg" alt="Lucas" style="width:40px;height:40px;border-radius:50%;"></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="prison_lucas" />
                                        <span class="slider"></span>
                                    </label>
                                </td>
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
                <!-- Répète pour les autres équipes avec d'autres données fictives -->
                <button class="accordion">Équipe 3 :</button>
                <div class="panel">
                    <table>
                        <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Surnom</th>
                                <th>Photo</th>
                                <th>En prison</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Julie</td>
                                <td>Petit</td>
                                <td>Juju</td>
                                <td><img src="/ctf_anna/ctf-challenge/public/images/avatar5.jpg" alt="Julie" style="width:40px;height:40px;border-radius:50%;"></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="prison_julie" />
                                        <span class="slider"></span>
                                    </label>
                                </td>
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
                                <td>Antoine</td>
                                <td>Moreau</td>
                                <td>Anto</td>
                                <td><img src="/ctf_anna/ctf-challenge/public/images/avatar6.jpg" alt="Antoine" style="width:40px;height:40px;border-radius:50%;"></td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" name="prison_antoine" />
                                        <span class="slider"></span>
                                    </label>
                                </td>
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
                <!-- Ajoute d'autres équipes si besoin -->
            </div>
        </div>
    </div>
    <div id="card-add-player">
        <div id="add-player-title">
            <h3>Ajouter un joueur</h3>
        </div>
        <form action="/create.php" method="post">
            <label for="username">Prénom du joueur :</label>
            <input type="text" id="username" name="username" required>
            <label for="username">Nom du joueur :</label>
            <input type="text" id="username" name="username" required>
            <label for="username">Surnom du joueur :</label>
            <input type="text" id="username" name="username" required>
            <label for="file">Photo du joueur :</label>
            <input type="file" id="file" name="file" required />
            <label for="file">Équipe :</label>
            <select id="select" name="select">
                <option value="Équipe">-- Sélectionnez --</option>
                <option value="option1">Équipe 1</option>
                <option value="option2">Équipe 2</option>
            </select>
            <div id="submit-login-button">
                <button type="submit">Ajouter le joueur</button>
            </div>
        </form>
    </div>
</div>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>