<?php 
require_once dirname(__FILE__) . '/includes/includes.php';
$count =0 ;

$result_artcs = $main -> getResults("select * from ".DB_DATABASE.".footer_links where link_type=1 and link_status=1 order by link_sort asc  ");
$result_tools = $main -> getResults("select * from ".DB_DATABASE.".footer_links where link_type=2 and link_status=1 order by link_sort asc  ");

$count = count($result_artcs);
if(count($result_tools)>$count){$count=count($result_tools);}

?>
</div>
			<!-----  footer Container  ------>
<div class="footer-div">
				<div class="footer-one">
					<div><span class="footer-span-one">Industry</span> <span class="footer-span-two">Articles</span></div>
					<div class="footer-div-two">
						
						<?php  foreach($result_artcs as $result) { ?>
						
							<div class="footer-div-two-inner"><span class="footer-div-two-span1">+</span>&nbsp;<span class="footer-div-two-span2"><a href="<?php echo $result->link_url ;?>" target="_blank"><?php echo $result->link_name ;?></a></span></div>
						
						<?php } ?>
					
						
					</div>
				</div>
				<div class="footer-two">
					<div><span class="footer-span-one">Push</span> <span class="footer-span-two">Tools</span></div>
					<div class="footer-div-two">
						<?php  foreach($result_tools as $result) { ?>
						
							<div class="footer-div-two-inner"><span class="footer-div-two-span1">+</span>&nbsp;<span class="footer-div-two-span2"><a href="<?php echo $result->link_url ;?>" target="_blank"><?php echo $result->link_name ;?></a></span></div>
						
						<?php } ?>
					</div>
				</div>
			</div>
			<!-----  copyright Container  ------>
			<div class="copyright">
				Copyright <?php echo date('Y'); ?>. All rights Reserved. Terms of Use | Privacy Policy
			</div>
		</div>
    </body>
</html>
