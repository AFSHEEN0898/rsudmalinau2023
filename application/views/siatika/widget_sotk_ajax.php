<div id="<?php echo $target; ?>" style="padding-top: 10px;">

<!--
We will create a family tree using just CSS(3)
The markup will be simple nested lists
-->
<style type="text/css">
  * {
  margin: 0;
  padding: 0;
}


/*baru*/
li.anak.garis + li{
  /*right: 29%;*/
  right: 120px;
}


li.anak.garis::after{
  /*right: auto;
    left: 50%;
    border-left: 3px solid #ccc;
    width: 355px;*/
}

/*./baru*/


.tree {
  text-align: center;
  padding-left: 10px;
}

.tree ul {
  display: block;
  white-space: nowrap;
  padding-top: 15px;
  position: relative;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
}


.tree li {
  vertical-align:top;
  display: inline-block;
  white-space: normal;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 15px 0px 0px 50px;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
  /*new :*/
  /*margin-left: -20px;*/
  /*top: 50%;*/
}




/*satu tingkat diatas (jfu/ sekretaris)*/
.top-unor li {
  vertical-align:top;
  display: inline-block;
  white-space: normal;
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 15px 100px 0px 100px;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
  /*top: 50%;*/
}


/*./satu tingkat diatas (jfu/ sekretaris)*/



/*We will use ::before and ::after to draw the connectors*/

.tree li::before,
.tree li::after {
  content: '';
  position: absolute;
  top: 0;
  right: 50%;
  border-top: 3px solid #ccc;
  width: 50%;
  height: 15px;
}

.tree li::after {
  right: auto;
  left: 50%;
  border-left: 3px solid #ccc;
}


/*Remove left-right connectors from elements without any siblings*/

.tree li:only-child::after,
.tree li:only-child::before {
  display: none;
}


/*Remove space from the top of single children*/

.tree li:only-child {
  padding-top: 0;
}


/*Remove left connector from first child and right connector from last child*/

ul.first li.first::before,
ul.first li.first::after {
  border: 0 none;
}

.tree li:first-child::before,
.tree li:last-child::after {
  border: 0 none;
}


/*Adding back the vertical connector to the last nodes*/

.tree li:last-child::before {
  border-right: 3px solid #ccc;
  border-radius: 0 5px 0 0;
  -webkit-border-radius: 0 5px 0 0;
  -moz-border-radius: 0 5px 0 0;
}

.tree li:first-child::after {
  border-radius: 5px 0 0 0;
  -webkit-border-radius: 5px 0 0 0;
  -moz-border-radius: 5px 0 0 0;
}


/*Time to add downward connectors from parents*/

.tree ul ul::before {
  content: '';
  position: absolute;
  top: -18px;
  left: 50%;
  border-left: 3px solid #ccc;
  width: 0;
  height: 33px;
  margin-left: -25px;
}

.tree li .box {
  border: 1px solid #ccc;
  padding: 5px 10px 5px 0px;
  text-decoration: none;
  color: #666;
  font-family: arial, verdana, tahoma;
  font-size: 12px;
  display: inline-block;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  transition: all .5s;
  -webkit-transition: all .5s;
  -moz-transition: all .5s;
  max-width: 250px;
}

/*garis-box pembatas*/
.garis-box {
    border-left: 3px solid #ccc;
    /*border-bottom: 3px solid #ccc;*/
    text-decoration: none;
    color: #666;
    font-family: arial, verdana, tahoma;
    font-size: 12px;
    display: inline-block;
    transition: all .5s;
    -webkit-transition: all .5s;
    -moz-transition: all .5s;
    margin-bottom: 15px;
    margin-left: -25px;
    min-height: 10cm;
    width: 26px;
    padding: 8px;

}


.vertical-text {
    width:1px;
    word-wrap: break-word;
    font-family: monospace; /* this is just for good looks */
    white-space: pre-wrap;
}



/*./garis-box pembatas*/


/*Hover effects*/

.tree li .box:hover,
.tree li .box:hover+ul li .box {
  /*background: #c8e4f8;*/
  color: #000;
  border: 1px solid #94a0b4;
}


/*Connector styles on hover*/

.tree li .box:hover+ul li::after,
.tree li .box:hover+ul li::before,
.tree li .box:hover+ul::before,
.tree li .box:hover+ul ul::before,
.avatar {
  border-color: #94a0b4;
}


/*Avatar bubbles*/

.avatar {
  position: relative;
  top: 0px;
  left: -35px;
  width: 75px;
  height: 75px;
  margin-right: -30px;
  background-size: cover;
  background-color: #fff;
  background-image: url("temp.jpg");
  float: left;
  border: .5px solid #94a0b4;
  border-radius: 50%;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
}



.table-peg {
	margin-left: 5px;
	margin-bottom: 27px;
}

/*scroll*/
.wmd-view-topscroll, .wmd-view
    {
        overflow-x: auto;
        overflow-y: hidden;
        width: 100%;
    }

    .wmd-view-topscroll
    {
        height: 16px;
    }

    .dynamic-div
    {
        display: inline-block;
    }
/*./scroll*/


/*sub*/
.vertikal {
  max-width:250px;
}

.vertikal li {
  float: left; 
  text-align: center;
  list-style-type: none;
  position: relative;
  /*display: grid;*/
  padding: 0 5px 10px 5px;
  /*border-left: 1px solid #ccc;*/
  border-left:0 !important;
  transition: all 0.5s;
  -webkit-transition: all 0.5s;
  -moz-transition: all 0.5s;
  margin-left:10px;
  top:-10px;
  z-index: 9;


}

.vertikal li::before{
    right: 66%;
    border-right: 3px solid #ccc !important;
    left: -13%;
    top: -6%;
    width: 58%;
    border-right: 3px solid #ccc;

    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;

}

.vertikal li::after{
    content: '';
    position: absolute;
    top: -6% !important;
    left: -14% !important;
    width: 59% !important;
    height: 100% !important;

    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}

.vertikal li:first-child::before {
    right: 66%;
    border-right: 3px solid #ccc !important;
    left: -2%;
    top: -6%;
    width: 58%;
    /*border-right: 3px solid red !important;*/
    border-right: none !important;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}

.vertikal li ul li:first-child::after {
    border-right: : none !important;
    left: -14% !important;
    width: 52% !important;
}


/*.vertikal li:last-child::before {
    right: 66%;
    border-left: 3px solid red !important;
    left: -2%;
    top: -6%;
    width: 58%;
    border-right: 3px solid red !important;
    border-right: none !important;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}*/




/*.vertikal li:first-child::after,*/
.vertikal li:first-child::after {
    border-right: : none !important;
    border-radius: 5px 5px 0 0;
    -webkit-border-radius: 5px 5px 0 0;
    -moz-border-radius: 5px 5px 0 0;
    left: -14% !important;
    width: 58% !important;

}

.vertikal li.anak::before {
    right: 66%;
    border-right: 3px solid #ccc !important;
    left: -13%;
    top: -2%;
    width: 58%;
    border-right: 3px solid #ccc;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}

.vertikal li.anak::after {
    content: '';
    position: absolute;
    top: -2% !important;
    left: -14% !important;
    width: 51% !important;
    height: 100% !important;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}

.vertikal li.anak:first-child::before {
    right: 66%;
    border-right: 3px solid #ccc !important;
    left: -2%;
    top: -6%;
    width: 58%;
    /*border-right: 3px solid red !important;*/
    border-right: none !important;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}




/*.vertikal li:first-child::after,*/
.vertikal li:last-child::after {
    width: 12px !important;
    /*border-left: 3px solid #ccc !important;*/
    top: -104% !important;
    border-top: none !important;
}

.vertikal li .box {
  border: 1px solid #ccc;
  padding: 5px 10px 5px 0px;
  text-decoration: none;
  color: #666;
  font-family: arial, verdana, tahoma;
  font-size: 12px;
  display: inline-block;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  transition: all .5s;
  -webkit-transition: all .5s;
  -moz-transition: all .5s;
  max-width: 250px;
}

/*./sub

/*set skala*/
.scaled {
  /*transform: scale(0.4, 0.4);
    transform-origin: top;
    margin-left: -35% !important;*/
  /*top: 0px !important;*/
  /*Equal to scaleX(0.7) scaleY(0.7) */


}
/*./set skala*/

.scaled{
  /*General*/
/*General*/
/*transform: translate(-25%, -10%) scale(0.5, 0.8);*/
/*Firefox*/
/*-moz-transform: translate(-25%, -10%) scale(0.5, 0.8);*/
/*Microsoft Internet Explorer*/
/*-ms-transform: translate(-25%, -10%) scale(0.5, 0.8);*/
/*Chrome, Safari*/
-webkit-transform: translate(-25%, -30%) scale(0.5, 0.4);
/*transform-origin: top;*/

/*Opera*/
/*-o-transform: translate(-25%, -10%) scale(0.5, 0.8);*/

}

</style>
<div class="box">
	<div class="box-body">

		<!-- <div class="wmd-view">
		    <div class="dynamic-div"> -->
		        <!-- bagan -->
		        <div class="tree scaled">
    				  <?php echo @$bso; ?>
    				</div>
		        <!-- ./bagan -->
	<!-- 	    </div>
		</div> -->
		
	</div>
</div>


<script>
    $(window).load(function () {
        $('.scroll-div').css('width', $('.dynamic-div').outerWidth() );
    });

	$(function(){
	    $(".wmd-view-topscroll").scroll(function () {
	    $(".wmd-view")
	    .scrollLeft($(".wmd-view-topscroll").scrollLeft());
	    });

	    $(".wmd-view").scroll(function () {
	        $(".wmd-view-topscroll")
	        .scrollLeft($(".wmd-view").scrollLeft());
	    });
	});

  // drag scroll
  
  // ./drag scroll

</script>

<?php
echo $paging_sub;
?>
</div>