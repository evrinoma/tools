<?php


namespace App\QuantitySurveyor\AgGrid;


class ColumnDef
{
//region SECTION: Fields
    public const NUMBER_COLUMN = 'numberColumn';
    public const DATE_COLUMN   = 'dateColumn';
    /**
     * @var string
     */
    private $field;
    /**
     * @var array|string
     */
    private $type;
    /**
     * @var string
     */
    private $headerName;
    /**
     * @var int
     */
    private $width;
    private $cellEditor;
    private $cellEditorParams;
    private $valueFormatter;
    private $valueParser;
    private $cellRenderer;
    private $groupId;
    private $children;
    /**
     * @var bool
     */
    private $editable = true;
    /**
     * @var bool
     */
    private $resizable = true;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isEditable(): bool
    {
        return $this->editable;
    }

    /**
     * @return bool
     */
    public function isResizable(): bool
    {
        return $this->resizable;
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getHeaderName(): string
    {
        return $this->headerName;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param string $type
     *
     * @return ColumnDef
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string $field
     *
     * @return ColumnDef
     */
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @param string $headerName
     *
     * @return ColumnDef
     */
    public function setHeaderName(string $headerName): self
    {
        $this->headerName = $headerName;

        return $this;
    }

    /**
     * @param int $width
     *
     * @return ColumnDef
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @param bool $editable
     *
     * @return ColumnDef
     */
    public function setEditable(bool $editable = false): self
    {
        $this->editable = $editable;

        return $this;
    }

    /**
     * @param bool $resizable
     *
     * @return ColumnDef
     */
    public function setResizable(bool $resizable = false): self
    {
        $this->resizable = $resizable;

        return $this;
    }


//endregion Getters/Setters

}