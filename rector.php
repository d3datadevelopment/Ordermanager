<?php

/**
 * Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\ClassMethod\InlineArrayReturnAssignRector;
use Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector;
use Rector\Php80\Rector\FunctionLike\MixedTypeRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\ClassMethod\BoolReturnTypeFromStrictScalarReturnsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ParamTypeByMethodCallTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnDirectArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictBoolReturnExprRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictNewArrayRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictScalarReturnExprRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnUnionTypeRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictArrayParamDimFetchRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictStringParamConcatRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/.',
    ]);

    $rectorConfig->bootstrapFiles([
        __DIR__.'/../../oxid-esales/oxideshop-ce/source/oxfunctions.php',
        __DIR__.'/../../oxid-esales/oxideshop-ce/source/overridablefunctions.php',
    ]);

    $pathExcludes = [
        __DIR__ . '/Modules' => [
            // Type Declaration                         // prevent changing the interface of extended methods
            AddVoidReturnTypeWhereNoReturnRector::class,
            ReturnTypeFromStrictScalarReturnExprRector::class,
            StrictStringParamConcatRector::class,
            ParamTypeByMethodCallTypeRector::class,
            ReturnTypeFromReturnDirectArrayRector::class,
            ReturnTypeFromStrictBoolReturnExprRector::class,
            ReturnTypeFromStrictTypedCallRector::class,
            ReturnUnionTypeRector::class,
            StrictArrayParamDimFetchRector::class,
            BoolReturnTypeFromStrictScalarReturnsRector::class,
            ReturnTypeFromStrictNewArrayRector::class,

            // Dead Code
            RemoveParentCallWithoutParentRector::class,     // Rector don't know module parents

            // Code Quality                                 // Rector don't know module parents
            ForeachItemsAssignToEmptyArrayToAssignRector::class,
            InlineArrayReturnAssignRector::class,
            CompleteDynamicPropertiesRector::class,
        ],
    ];

    $skipRules = [];
    array_walk($pathExcludes, static function ($item, $key) use (&$skipRules): void {
        foreach ($item as $classList) {
            $skipRules[$classList] ??= [];
            $skipRules[$classList][] = $key;
        }
    });

    $rectorConfig->skip(
        array_merge(
            [
                __DIR__ . '/tests',
                MixedTypeRector::class,                             // shouldn't remove argument annotations
            ],
            $skipRules
        )
    );

    // define sets of rules
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_80,     // lowest possible PHP version for this plugin is 8.0
        SetList::TYPE_DECLARATION,
        SetList::INSTANCEOF,
        SetList::EARLY_RETURN,
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
    ]);

    $rectorConfig->importNames();
};
