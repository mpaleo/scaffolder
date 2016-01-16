<?php

namespace Scaffolder\Themes;

interface ScaffolderThemeExtensionInterface
{
    /**
     * This extension is run after the create view is compiled.
     *
     * @param $compiledStub
     * @param $modelData
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterCreateViewIsCompiled($compiledStub, $modelData, $scaffolderConfig);

    /**
     * This extension is run after the edit view is compiled.
     *
     * @param $compiledStub
     * @param $modelData
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterEditViewIsCompiler($compiledStub, $modelData, $scaffolderConfig);

    /**
     * This extension is run after the index view is compiled.
     *
     * @param $compiledStub
     * @param $modelData
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterIndexViewIsCompiled($compiledStub, $modelData, $scaffolderConfig);

    /**
     * This extension is run after the dashboard view is compiled.
     *
     * @param $compiledStub
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterDashboardViewIsCompiled($compiledStub, $scaffolderConfig);

    /**
     * This extension is run after the welcome view is compiled.
     *
     * @param $compiledStub
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterWelcomeViewIsCompiled($compiledStub, $scaffolderConfig);

    /**
     * This extension is run after the login view is compiled.
     *
     * @param $compiledStub
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterLoginViewIsCompiled($compiledStub, $scaffolderConfig);

    /**
     * This extension is run after the create layout is compiled.
     *
     * @param $compiledStub
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterCreateLayoutIsCompiled($compiledStub, $scaffolderConfig);

    /**
     * This extension is run after the edit layout is compiled.
     *
     * @param $compiledStub
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterEditLayoutIsCompiled($compiledStub, $scaffolderConfig);

    /**
     * This extension is run after the page layout is compiled.
     *
     * @param $compiledStub
     * @param $scaffolderConfig
     *
     * @return string Should return the modified compiled stub.
     */
    public function runAfterPageLayoutIsCompiled($compiledStub, $scaffolderConfig);
}
