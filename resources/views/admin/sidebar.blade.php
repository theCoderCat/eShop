<!-- ========== Left Sidebar Start ========== -->
<div class="left-sidebar">
    <div class="left-sidebar-wrapper">
        <a href="#" class="left-sidebar-toggle"></a>
        <div class="left-sidebar-content">
            <ul class="sidebar-elements">
                <li v-for="(link, index) in sidebarLinks" :class="{ active: link.isActive, 'has-sub': link.submenu.length }">
                    <template v-if="!link.submenu.length">
                    <router-link :to="{ name: link.routeName }">@{{link.title}}</router-link>
                    </template>
                    <template v-else>
                        <a href="#" @click.prevent="toggleSubmenu(index)">@{{ link.title }}</a>
                        <ul class="submenu">
                            <li v-for="(sublink, subindex) in link.submenu">
                                <router-link :to="{ name: sublink.routeName }">@{{sublink.title}}</router-link>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->