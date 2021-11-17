{{--begin::Aside Menu--}}
<?php
$menu = \App\Core\Adapters\Bootstrap::getAsideMenu();

if (\App\Core\Adapters\Bootstrap::isDocumentationMenu()) {
    $menu->setItemLinkClass("py-2");

    $menu->addCallback("heading", function ($heading) {
        $html = '<h4 class="menu-content text-muted mb-0 fs-7 text-uppercase">';
        $html .= $heading;
        $html .= '</h4>';

        return $html;
    });
}

$menuClasses = '';
?>

<div
    class="hover-scroll-overlay-y my-5 my-lg-5"
    id="kt_aside_menu_<?php util()->putIf(\App\Core\Adapters\Bootstrap::isDocumentationMenu(), 'docs_')?>wrapper"
    data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}"
    data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
    data-kt-scroll-wrappers="#kt_aside_menu"
    data-kt-scroll-offset="0"
>
    {{--begin::Menu--}}
    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 {{ $menuClasses }}" id="#kt_aside_menu" data-kt-menu="true">
        <?php
        $menu->build();
        ?>
    </div>
    {{--end::Menu--}}
</div>
{{--end::Aside Menu--}}
