<?php
class PluginBuyMeACoffee extends Plugin
{
    public function init()
    {
        $this->dbFields = array(
            'buymeacoffee_url' => '',
            'enable_sidebar' => 'yes',
            'enable_pages' => 'yes',
            'custom_text' => '<b>Enjoying my writings? Consider purchasing me a coffee or two! ☕</b>',
            'button_instead' => 'no',
            'button_color' => 'primary'
        );
    }

    public function form()
    {
        global $L;

        $html = '';

        $html .= '<div>';
        $html .= '<label for="buymeacoffee_url">' . $L->get('Buy Me a Coffee URL') . '</label>';
        $html .= '<input type="text" name="buymeacoffee_url" id="buymeacoffee_url" value="' . $this->getValue('buymeacoffee_url') . '" placeholder="https://www.buymeacoffee.com/">';
        $html .= '</div>';

        $html .= '<hr>';

        $html .= '<div>';
        $html .= '<label>' . $L->get('Show Sidebar Image') . '</label>';
        $html .= '<select name="enable_sidebar">';
        $html .= '<option value="yes" ' . ($this->getValue('enable_sidebar') === 'yes' ? 'selected' : '') . '>' . $L->get('Yes') . '</option>';
        $html .= '<option value="no" ' . ($this->getValue('enable_sidebar') === 'no' ? 'selected' : '') . '>' . $L->get('No') . '</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<hr>';

        $html .= '<div>';
        $html .= '<label>' . $L->get('Show Text on Pages') . '</label>';
        $html .= '<select name="enable_pages">';
        $html .= '<option value="yes" ' . ($this->getValue('enable_pages') === 'yes' ? 'selected' : '') . '>' . $L->get('Yes') . '</option>';
        $html .= '<option value="no" ' . ($this->getValue('enable_pages') === 'no' ? 'selected' : '') . '>' . $L->get('No') . '</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label for="custom_text">' . $L->get('Text Shown at Bottom <small>(HTML supported)</small>') . '</label>';
        $html .= '<textarea name="custom_text" id="custom_text" rows="5">' . $this->getValue('custom_text') . '</textarea>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>' . $L->get('Button Instead of Image') . '</label>';
        $html .= '<select name="button_instead">';
        $html .= '<option value="yes" ' . ($this->getValue('button_instead') === 'yes' ? 'selected' : '') . '>' . $L->get('Yes') . '</option>';
        $html .= '<option value="no" ' . ($this->getValue('button_instead') === 'no' ? 'selected' : '') . '>' . $L->get('No') . '</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>' . $L->get('Button Color') . '</label>';
        $html .= '<select name="button_color">';
        $html .= '<option value="primary" ' . ($this->getValue('button_color') === 'primary' ? 'selected' : '') . '>' . $L->get('Primary') . '</option>';
        $html .= '<option value="secondary" ' . ($this->getValue('button_color') === 'secondary' ? 'selected' : '') . '>' . $L->get('Secondary') . '</option>';
        $html .= '<option value="success" ' . ($this->getValue('button_color') === 'success' ? 'selected' : '') . '>' . $L->get('Green') . '</option>';
        $html .= '<option value="danger" ' . ($this->getValue('button_color') === 'danger' ? 'selected' : '') . '>' . $L->get('Red') . '</option>';
        $html .= '<option value="warning" ' . ($this->getValue('button_color') === 'warning' ? 'selected' : '') . '>' . $L->get('Yellow') . '</option>';
        $html .= '<option value="info" ' . ($this->getValue('button_color') === 'info' ? 'selected' : '') . '>' . $L->get('Blue') . '</option>';
        $html .= '<option value="light" ' . ($this->getValue('button_color') === 'light' ? 'selected' : '') . '>' . $L->get('Light') . '</option>';
        $html .= '<option value="dark" ' . ($this->getValue('button_color') === 'dark' ? 'selected' : '') . '>' . $L->get('Dark') . '</option>';
        $html .= '<option value="link" ' . ($this->getValue('button_color') === 'link' ? 'selected' : '') . '>' . $L->get('Link') . '</option>';
        $html .= '</select>';
        $html .= '</div>';

        return $html;
    }

    public function siteSidebar()
    {
        $enableSidebarImage = $this->getValue('enable_sidebar');
        $buymeacoffeeURL = $this->getValue('buymeacoffee_url');

        $html = '';

        if ($enableSidebarImage === 'yes') {
            $html .= '<div class="plugin plugin-buymeacoffee-sidebar">';
            if ($buymeacoffeeURL) { $html .= '<a href="' . $buymeacoffeeURL . '" target="_blank">'; }
            $html .= '<img src="' . HTML_PATH_PLUGINS . 'buymeacoffee/bmc-button.png" alt="Buy Me a Coffee">';
            if ($buymeacoffeeURL) { $html .= '</a>'; }
            $html .= '</div>';
        }

        return $html;
    }

    public function pageEnd()
    {
        global $WHERE_AM_I, $page;

        $showOnPages = $this->getValue('enable_pages');
        $defaultCustomText = $this->getValue('custom_text');
        $showButtonInstead = $this->getValue('button_instead');
        $buttonColor = $this->getValue('button_color');
        $buymeacoffeeURL = $this->getValue('buymeacoffee_url');

        $customText = $page->custom('custom_text');
        if (empty($customText)) {
            $customText = $defaultCustomText;
        }

        if ($WHERE_AM_I === 'page' && $showOnPages === 'yes' && !empty($buymeacoffeeURL)) {
            echo '<hr>';
            echo '<div class="row">';
                echo '<div class="col-md-8" style="display: flex; justify-content: center; align-items: center;">';
                    echo htmlspecialchars_decode(stripslashes($customText));
                echo '</div>';
                echo '<div class="col-md-4" style="display: flex; justify-content: center; align-items: center;">';
                    if ($showButtonInstead === 'yes') {
                        echo '<a href="' . $buymeacoffeeURL . '" target="_blank" class="btn btn-' . $buttonColor . '">Buy Me A Coffee</a>';
                    } else {
                        echo '<a href="' . $buymeacoffeeURL . '" target="_blank">';
                            echo '<img src="' . HTML_PATH_PLUGINS . 'buymeacoffee/bmc-button.png" alt="Buy Me a Coffee">';
                        echo '</a>';
                    }
                echo '</div>';
            echo '</div>';
        }
    }
}