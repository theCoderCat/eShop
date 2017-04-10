<!-- ========== Left Sidebar Start ========== -->
<div class="left-sidebar">
    <div class="left-sidebar-wrapper">
        <a href="#" class="left-sidebar-toggle">Dashboard</a>
        <div class="left-sidebar-content">
            <ul class="sidebar-elements">
                <li v-for="link in sidebarLinks">
                    <router-link :to="{ name: link.routeName }">@{{link.title}}</router-link>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->