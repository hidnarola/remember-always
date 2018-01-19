<footer class="footer">
    <div class="container">
        <div class="ftr-logo ftr-sepretor">
            <a href=""><img src="assets/images/ftr-logo.png" alt="" /> </a>
        </div>
        <div class="quick-link ftr-sepretor">
            <h3>Quick Link</h3>
            <ul>
                <li><a href="<?php echo site_url('/') ?>">Home</a></li>
                <li><a href="<?php echo site_url('blog') ?>">Blogs</a></li>
                <?php
                $header_links = get_pages('footer');
                if (isset($header_links)) {
                    foreach ($header_links as $key => $value) {
                        if (isset($value['sub_menus'])) {
                            foreach ($value['sub_menus'] as $key1 => $value1) {
                                ?>
                                <li class="">
                                    <a href="<?php echo site_url('pages/' . $value1['slug']); ?>"><?php echo $value1['navigation_name']; ?></a>
                                </li>
                                <?php
                            }
                        } else {
                            ?>
                            <li class="">
                                <a href="<?php echo site_url('pages/' . $value['slug']); ?>"><?php echo $value['navigation_name']; ?></a>
                            </li>
                            <?php
                        }
                    }
                }
                ?>
                <li><a href="<?php echo site_url('contact') ?>">Contact</a></li>
            </ul>
        </div>
        <div class="ftr-contact ftr-sepretor">
            <h3>Contact us</h3>
            <p><strong>Address :</strong><br/><a href="https://www.google.com/maps/place/3415+W+Lake+Mary+Blvd+%23951965lake,+Lake+Mary,+FL+32746,+USA/@28.7554428,-81.3406926,17z/data=!4m5!3m4!1s0x88e76d583d725ad1:0x93eca9ac4182673a!8m2!3d28.7554428!4d-81.3385039" target="_blank"> 3415 W. Lake Mary Blvd. #951965 <br/> Lake Mary, FL 32795 </a></p>
            <p><strong>Phone :</strong> 863-703-6036</p>
            <p><strong>E-mail :</strong> support@rememberalways.com</p>
        </div>
        <div class="ftr-follow ftr-sepretor">
            <h3>Follow Us</h3>
            <a href="">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="49.652px" height="49.652px" viewBox="0 0 49.652 49.652" style="enable-background:new 0 0 49.652 49.652;"
                     xml:space="preserve">
                <g>
                <g>
                <path d="M24.826,0C11.137,0,0,11.137,0,24.826c0,13.688,11.137,24.826,24.826,24.826c13.688,0,24.826-11.138,24.826-24.826
                      C49.652,11.137,38.516,0,24.826,0z M31,25.7h-4.039c0,6.453,0,14.396,0,14.396h-5.985c0,0,0-7.866,0-14.396h-2.845v-5.088h2.845
                      v-3.291c0-2.357,1.12-6.04,6.04-6.04l4.435,0.017v4.939c0,0-2.695,0-3.219,0c-0.524,0-1.269,0.262-1.269,1.386v2.99h4.56L31,25.7z
                      "/>
                </g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                </svg>
            </a>
            <a href="">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="49.652px" height="49.652px" viewBox="0 0 49.652 49.652" style="enable-background:new 0 0 49.652 49.652;"
                     xml:space="preserve">
                <g>
                <g>
                <path d="M24.826,0C11.137,0,0,11.137,0,24.826c0,13.688,11.137,24.826,24.826,24.826c13.688,0,24.826-11.138,24.826-24.826
                      C49.652,11.137,38.516,0,24.826,0z M35.901,19.144c0.011,0.246,0.017,0.494,0.017,0.742c0,7.551-5.746,16.255-16.259,16.255
                      c-3.227,0-6.231-0.943-8.759-2.565c0.447,0.053,0.902,0.08,1.363,0.08c2.678,0,5.141-0.914,7.097-2.446
                      c-2.5-0.046-4.611-1.698-5.338-3.969c0.348,0.066,0.707,0.103,1.074,0.103c0.521,0,1.027-0.068,1.506-0.199
                      c-2.614-0.524-4.583-2.833-4.583-5.603c0-0.024,0-0.049,0.001-0.072c0.77,0.427,1.651,0.685,2.587,0.714
                      c-1.532-1.023-2.541-2.773-2.541-4.755c0-1.048,0.281-2.03,0.773-2.874c2.817,3.458,7.029,5.732,11.777,5.972
                      c-0.098-0.419-0.147-0.854-0.147-1.303c0-3.155,2.558-5.714,5.713-5.714c1.644,0,3.127,0.694,4.171,1.804
                      c1.303-0.256,2.523-0.73,3.63-1.387c-0.43,1.335-1.333,2.454-2.516,3.162c1.157-0.138,2.261-0.444,3.282-0.899
                      C37.987,17.334,37.018,18.341,35.901,19.144z"/>
                </g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                </svg>
            </a>
            <a href="">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="49.652px" height="49.652px" viewBox="0 0 49.652 49.652" style="enable-background:new 0 0 49.652 49.652;"
                     xml:space="preserve">
                <g>
                <g>
                <g>
                <path d="M21.5,28.94c-0.161-0.107-0.326-0.223-0.499-0.34c-0.503-0.154-1.037-0.234-1.584-0.241h-0.066
                      c-2.514,0-4.718,1.521-4.718,3.257c0,1.89,1.889,3.367,4.299,3.367c3.179,0,4.79-1.098,4.79-3.258
                      c0-0.204-0.024-0.416-0.075-0.629C23.432,30.258,22.663,29.735,21.5,28.94z"/>
                <path d="M19.719,22.352c0.002,0,0.002,0,0.002,0c0.601,0,1.108-0.237,1.501-0.687c0.616-0.702,0.889-1.854,0.727-3.077
                      c-0.285-2.186-1.848-4.006-3.479-4.053l-0.065-0.002c-0.577,0-1.092,0.238-1.483,0.686c-0.607,0.693-0.864,1.791-0.705,3.012
                      c0.286,2.184,1.882,4.071,3.479,4.121H19.719L19.719,22.352z"/>
                <path d="M24.826,0C11.137,0,0,11.137,0,24.826c0,13.688,11.137,24.826,24.826,24.826c13.688,0,24.826-11.138,24.826-24.826
                      C49.652,11.137,38.516,0,24.826,0z M21.964,36.915c-0.938,0.271-1.953,0.408-3.018,0.408c-1.186,0-2.326-0.136-3.389-0.405
                      c-2.057-0.519-3.577-1.503-4.287-2.771c-0.306-0.548-0.461-1.132-0.461-1.737c0-0.623,0.149-1.255,0.443-1.881
                      c1.127-2.402,4.098-4.018,7.389-4.018c0.033,0,0.064,0,0.094,0c-0.267-0.471-0.396-0.959-0.396-1.472
                      c0-0.255,0.034-0.515,0.102-0.78c-3.452-0.078-6.035-2.606-6.035-5.939c0-2.353,1.881-4.646,4.571-5.572
                      c0.805-0.278,1.626-0.42,2.433-0.42h7.382c0.251,0,0.474,0.163,0.552,0.402c0.078,0.238-0.008,0.5-0.211,0.647l-1.651,1.195
                      c-0.099,0.07-0.218,0.108-0.341,0.108H24.55c0.763,0.915,1.21,2.22,1.21,3.685c0,1.617-0.818,3.146-2.307,4.311
                      c-1.15,0.896-1.195,1.143-1.195,1.654c0.014,0.281,0.815,1.198,1.699,1.823c2.059,1.456,2.825,2.885,2.825,5.269
                      C26.781,33.913,24.89,36.065,21.964,36.915z M38.635,24.253c0,0.32-0.261,0.58-0.58,0.58H33.86v4.197
                      c0,0.32-0.261,0.58-0.578,0.58h-1.195c-0.322,0-0.582-0.26-0.582-0.58v-4.197h-4.192c-0.32,0-0.58-0.258-0.58-0.58V23.06
                      c0-0.32,0.26-0.582,0.58-0.582h4.192v-4.193c0-0.321,0.26-0.58,0.582-0.58h1.195c0.317,0,0.578,0.259,0.578,0.58v4.193h4.194
                      c0.319,0,0.58,0.26,0.58,0.58V24.253z"/>
                </g>
                </g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                </svg>
            </a>
            <a href="">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="49.652px" height="49.652px" viewBox="0 0 49.652 49.652" style="enable-background:new 0 0 49.652 49.652;"
                     xml:space="preserve">
                <g>
                <g>
                <g>
                <path d="M24.825,29.796c2.739,0,4.972-2.229,4.972-4.97c0-1.082-0.354-2.081-0.94-2.897c-0.903-1.252-2.371-2.073-4.029-2.073
                      c-1.659,0-3.126,0.82-4.031,2.072c-0.588,0.816-0.939,1.815-0.94,2.897C19.854,27.566,22.085,29.796,24.825,29.796z"/>
                <polygon points="35.678,18.746 35.678,14.58 35.678,13.96 35.055,13.962 30.891,13.975 30.907,18.762 			"/>
                <path d="M24.826,0C11.137,0,0,11.137,0,24.826c0,13.688,11.137,24.826,24.826,24.826c13.688,0,24.826-11.138,24.826-24.826
                      C49.652,11.137,38.516,0,24.826,0z M38.945,21.929v11.56c0,3.011-2.448,5.458-5.457,5.458H16.164
                      c-3.01,0-5.457-2.447-5.457-5.458v-11.56v-5.764c0-3.01,2.447-5.457,5.457-5.457h17.323c3.01,0,5.458,2.447,5.458,5.457V21.929z"
                      />
                <path d="M32.549,24.826c0,4.257-3.464,7.723-7.723,7.723c-4.259,0-7.722-3.466-7.722-7.723c0-1.024,0.204-2.003,0.568-2.897
                      h-4.215v11.56c0,1.494,1.213,2.704,2.706,2.704h17.323c1.491,0,2.706-1.21,2.706-2.704v-11.56h-4.217
                      C32.342,22.823,32.549,23.802,32.549,24.826z"/>
                </g>
                </g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                </svg>
            </a>
            <a href="">
                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     width="49.652px" height="49.652px" viewBox="0 0 49.652 49.652" style="enable-background:new 0 0 49.652 49.652;"
                     xml:space="preserve">
                <g>
                <g>
                <g>
                <path d="M29.35,21.298c-2.125,0-3.074,1.168-3.605,1.988v-1.704h-4.002c0.052,1.128,0,12.041,0,12.041h4.002v-6.727
                      c0-0.359,0.023-0.72,0.131-0.977c0.29-0.72,0.948-1.465,2.054-1.465c1.448,0,2.027,1.104,2.027,2.724v6.442h4.002h0.001v-6.905
                      C33.958,23.019,31.983,21.298,29.35,21.298z M25.742,23.328h-0.025c0.008-0.014,0.02-0.027,0.025-0.041V23.328z"/>
                <rect x="15.523" y="21.582" width="4.002" height="12.041"/>
                <path d="M24.826,0C11.137,0,0,11.137,0,24.826c0,13.688,11.137,24.826,24.826,24.826c13.688,0,24.826-11.138,24.826-24.826
                      C49.652,11.137,38.516,0,24.826,0z M37.991,36.055c0,1.056-0.876,1.91-1.959,1.91H13.451c-1.08,0-1.957-0.854-1.957-1.91V13.211
                      c0-1.055,0.877-1.91,1.957-1.91h22.581c1.082,0,1.959,0.856,1.959,1.91V36.055z"/>
                <path d="M17.551,15.777c-1.368,0-2.264,0.898-2.264,2.08c0,1.155,0.869,2.08,2.211,2.08h0.026c1.396,0,2.265-0.925,2.265-2.08
                      C19.762,16.676,18.921,15.777,17.551,15.777z"/>
                </g>
                </g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                <g>
                </g>
                </svg>
            </a>
        </div>
        <div class="ftr-btm">
            <p>© Copyright 2017  -  All Right Reserved. </p>
        </div>
    </div>
</footer>