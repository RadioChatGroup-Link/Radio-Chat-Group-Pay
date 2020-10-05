    <footer class="footer">
      <div class="container-fluid">
        <div class="copyright ml-auto">
        	Copyright &copy; 2016-<?=date('Y')?> <?php echo $conf['web_name']?> - <?php echo $_SERVER['SERVER_NAME']?>
      </div>
    </footer>
    <!-- footer end -->
   </div>
  </div>
</div>
<script src="//lib.baomitu.com/jquery/3.2.1/jquery.min.js"></script>
<script src="//shepay.ayunx.com/user/js/jquery-ui.min.js"></script>
<script src="//shepay.ayunx.com/user/js/popper.min.js"></script>
<script src="//lib.baomitu.com/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//shepay.ayunx.com/user/js/bootstrap-toggle.min.js"></script>
<script src="//shepay.ayunx.com/user/js/jquery.scrollbar.min.js"></script>
<script src="//shepay.ayunx.com/user/js/ready.js"></script>
<script src="//shepay.ayunx.com/user/js/ready.min.js"></script>
<script type='text/javascript'>
    (function(m, ei, q, i, a, j, s) {
        m[i] = m[i] || function() {
            (m[i].a = m[i].a || []).push(arguments)
        };
        j = ei.createElement(q),
            s = ei.getElementsByTagName(q)[0];
        j.async = true;
        j.charset = 'UTF-8';
        j.src = 'https://static.meiqia.com/dist/meiqia.js?_=t';
        s.parentNode.insertBefore(j, s);
    })(window, document, 'script', '_MEIQIA');
    _MEIQIA('entId', <?php echo $conf['kfset_mqid']?>);
    </script>
</body>
</html>
<!-- 用户中心模板原创自都潮汇系统，盗版狗必死 -->