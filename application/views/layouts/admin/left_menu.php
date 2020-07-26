<nav>
	<ul class="sidebar-menu" data-widget="tree">
		<li class="sidemenu-user-profile d-flex align-items-center">
			<div class="user-thumbnail">
                <?php
                if (is_file(APPPATH . '../public/' . $this->session->userdata['file_picture']) && file_exists(APPPATH . '../public/' . $this->session->userdata['file_picture'])) {
                    ?>
					  <img
					src="<?php echo base_url().'public/'.$this->session->userdata['file_picture']?>"
					alt="">
				<?php
                } else {
                    ?>
					  <img class="border-radius-50"
					src="<?php echo base_url()?>public/uploads/no_image.jpg">
				<?php
                }
                ?>
            </div>
			<div class="user-content">
				<h6><?php echo $this->session->userdata['first_name']?> <?php echo $this->session->userdata['last_name']?></h6>
				<!--<span>Pro User</span>-->
			</div>
		</li>
        <li <?php if($this->router->fetch_class()=="homecontroller"){?>
					class="active" <?php }?>><a href="<?php echo site_url('homecontroller'); ?>"><i class="icon_lifesaver"></i> <span>Dashboard</span></a></li>
        <?php
        $menu_open = false;
        if ($this->router->fetch_class() == "profile" || $this->router->fetch_class() == "country" || $this->router->fetch_class() == "company" || $this->router->fetch_class() == "users") {
            $menu_open = true;
        }
        ?>
        <li
			class="treeview <?php if($menu_open==true){?>menu-open<?php }?>"><a
			href="javascript:void(0)"><i class="icon_key_alt"></i> <span>Settings</span>
				<i class="fa fa-angle-right"></i></a>
			<ul class="treeview-menu" <?php if($menu_open==true){?>
				style="display: block;" <?php }?>>
				<li <?php if($this->router->fetch_class()=="profile"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/profile/index'); ?>"><i
						class="icon_table"></i>Profile</a></li>
				<li <?php if($this->router->fetch_class()=="country"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/country/index'); ?>"><i
						class="icon_table"></i>Country</a></li>
				<li <?php if($this->router->fetch_class()=="company"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/company/index'); ?>"><i
						class="icon_table"></i>Company</a></li>
				<li <?php if($this->router->fetch_class()=="users"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/users/index'); ?>"><i
						class="icon_table"></i>Users</a></li>
			</ul></li> 
        
         <?php
        $menu_open = false;
        if ($this->router->fetch_class() == "category" || $this->router->fetch_class() == "sub_category" || $this->router->fetch_class() == "customers" || $this->router->fetch_class() == "supplier" || $this->router->fetch_class() == "customers" || $this->router->fetch_class() == "product") {
            $menu_open = true;
        }
        ?>
        <li
			class="treeview <?php if($menu_open==true){?>menu-open<?php }?>"><a
			href="javascript:void(0)"><i class="icon_genius"></i> <span>Product
					Settings</span> <i class="fa fa-angle-right"></i></a>
			<ul class="treeview-menu" <?php if($menu_open==true){?>
				style="display: block;" <?php }?>>
				<li <?php if($this->router->fetch_class()=="category"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/category/index'); ?>"><i
						class="icon_table"></i>Category</a></li>
				<li <?php if($this->router->fetch_class()=="sub_category"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/sub_category/index'); ?>"><i
						class="icon_table"></i>Sub Category</a></li>
				<li <?php if($this->router->fetch_class()=="customers"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/customers/index'); ?>"><i
						class="icon_table"></i>Customers</a></li>
				<li <?php if($this->router->fetch_class()=="supplier"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/supplier/index'); ?>"><i
						class="icon_table"></i>Supplier</a></li>
				<li <?php if($this->router->fetch_class()=="product"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/product/index'); ?>"><i
						class="icon_table"></i>Product</a></li>
			</ul></li> 
        
        <?php
        $menu_open = false;
        if ($this->router->fetch_class() == "purchase" || $this->router->fetch_class() == "item_purchase") {
            $menu_open = true;
        }
        ?>
        <li
			class="treeview <?php if($menu_open==true){?>menu-open<?php }?>"><a
			href="javascript:void(0)"><i class="icon_document_alt"></i> <span>Purchase</span>
				<i class="fa fa-angle-right"></i></a>
			<ul class="treeview-menu" <?php if($menu_open==true){?>
				style="display: block;" <?php }?>>
				<li <?php if($this->router->fetch_class()=="purchase"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/purchase/index'); ?>"><i
						class="icon_table"></i>Purchase</a></li>
				<li <?php if($this->router->fetch_class()=="item_purchase"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/item_purchase/index'); ?>"><i
						class="icon_table"></i>Item Purchase</a></li>
			</ul></li> 
        <?php
        $menu_open = false;
        if ($this->router->fetch_class() == "invoice" || $this->router->fetch_class() == "item_invoice") {
            $menu_open = true;
        }
        ?>
        <li
			class="treeview <?php if($menu_open==true){?>menu-open<?php }?>"><a
			href="javascript:void(0)"><i class="icon_cart_alt"></i> <span>Sell</span>
				<i class="fa fa-angle-right"></i></a>
			<ul class="treeview-menu" <?php if($menu_open==true){?>
				style="display: block;" <?php }?>>
				<li <?php if($this->router->fetch_class()=="invoice"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/invoice/index'); ?>"><i
						class="icon_table"></i>Invoice</a></li>
				<li <?php if($this->router->fetch_class()=="item_invoice"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/item_invoice/index'); ?>"><i
						class="icon_table"></i>Item Invoice</a></li>
			</ul></li>
         <?php
        $menu_open = false;
        if ($this->router->fetch_class() == "report_product" ||
		    $this->router->fetch_class() == "report_purchase" ||
		    $this->router->fetch_class() == "report_invoice") {
            $menu_open = true;
        }
        ?>
        <li
			class="treeview <?php if($menu_open==true){?>menu-open<?php }?>"><a
			href="javascript:void(0)"><i class="icon_easel"></i> <span>Report</span>
				<i class="fa fa-angle-right"></i></a>
			<ul class="treeview-menu" <?php if($menu_open==true){?>
				style="display: block;" <?php }?>>

				<li <?php if($this->router->fetch_class()=="report_product"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/report_product/index'); ?>"><i
						class="icon_table"></i>Products</a></li>
				<li <?php if($this->router->fetch_class()=="report_purchase"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/report_purchase/index'); ?>"><i
						class="icon_table"></i>Purchase</a></li>
				<li <?php if($this->router->fetch_class()=="report_invoice"){?>
					class="active" <?php }?>><a
					href="<?php echo site_url('admin/report_invoice/index'); ?>"><i
						class="icon_table"></i>Sell</a></li>
			</ul></li>
            
	</ul>
</nav>
