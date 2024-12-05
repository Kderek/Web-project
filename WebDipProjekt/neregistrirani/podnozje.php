        </div>
        <footer>
            <?php
            if (isset($_POST['uvjeti']))
            {
                setcookie("uvjeti", true, time()+172.800);
            }
            if (!isset($_POST['uvjeti']) && (!isset($_SESSION[Sesija::ULOGA]) || $_SESSION[Sesija::ULOGA] == 0))
            {
                if (!isset($_COOKIE['uvjeti']))
                {
                    echo "<form name=\"kolacicic\" method=\"post\" action=\"\">
                    Prihvati kolačiće? <input type=\"submit\" name=\"uvjeti\" value=\"Da\"/>
                    </form>";
                }
            }
            ?>
            <div class="footer">
                <div class="copyright">
                    &copy; 2022  &#124; <a href="mailto:someone@yoursite.com">Kvirin Đerek</a>
                </div>
            </div>
        </footer>
    </body>
</html>