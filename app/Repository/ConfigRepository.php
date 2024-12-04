<?php

namespace App\Repository;

use App\Models\ShopConfig;

class ConfigRepository
{
    /**
     * 获取所有配置
     *
     * @return array
     */
    public function getAllConfig()
    {
        static $data;
        if (is_null($data)) {
            $data = ShopConfig::pluck('value', 'name');
        }
        return $data;
    }

    /**
     * 获取配置值
     *
     * @param string $name
     * @param string|null $default
     * @return string|null
     */
    public function getConfig($name, $default = null)
    {
        $data = $this->getAllConfig();
        return $data[$name] ?? $default;
    }

    /**
     * 修改配置值
     *
     * @param string $name
     * @param string $value
     * @return bool
     */
    public function saveConfig($name, $value)
    {
        $rs = ShopConfig::where('name', $name)->update(['value' => $value]);
        return $rs;
    }

    /**
     * 主题文字
     *
     * @param string $val
     * @return string
     */
    public function returnThemeTxt($val)
    {
        return ShopConfig::themeRel()[$val] ?? '';
    }
}
