<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2019-2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

/// The namespace for @aponica/assert-properties-php
///
/// This is a convenient way to assert, for example, that certain parameters
/// or options have been provided. By default, all specified properties must
/// be defined (an "and" check), but it is also possible to specify that a
/// certain number of the possibilities are defined (an "or" check).
///
/// An equivalent JS package, @aponica/assert-properies-js, is available,
/// and should be kept synchronized with this version for consistency.

namespace Aponica\AssertProperties;

//-----------------------------------------------------------------------------
/// Throws an error if an object doesn't contain a top-level property.
///
/// This is a convenient way to assert, for example, that certain parameters
/// or options have been provided. By default, all specified properties must
/// be defined (an "and" check), but it is also possible to specify that a
/// certain number of the possibilities are defined (an "or" check).
///
/// @param hObject
///   The object that must contain a specified list of properties.
///
/// @param azPropertyNames
///   The array of property names (each a string) that must all exist in
///   hObject.
///
/// @param hOptions
///   A hash (dictionary object) of options that may include:
///
///     @param hOptions[zLabel]
///       A label describing the object (used in any error message,
///       defaults to 'invalid hash').
///
///     @param hOptions[bUseIn]
///       If true, use the JS "in" operator instead of the default
///       Object.hasOwnProperty() to test for the existence of each property.
///
///     @param hOptions[nMax]
///       If specified, then no more than this number of the specified
///       property names can appear.
///
///     @param hOptions[nMin]
///       If specified, then at least this number of the specified
///       property names must appear (not necessarily all of them).
///
/// @throws Exception
///   If a property is missing from the hash, an error is thrown describing
///   the property name missing from the object label.
//-----------------------------------------------------------------------------

function fAssertProperties(
  array $hObject, array $azPropertyNames, array $hOptions = [] ) : void {

    $nCount = count( $azPropertyNames );
    $hSettings = array_merge(
      [ // defaults
        'zLabel' => 'invalid hash',
        'nMax' => $nCount,
        'nMin' => $nCount
        ], // defaults
      $hOptions
      ); // hSettings

    $nPresent = 0;
    for ( $n = 0 ; $n < count( $azPropertyNames ) ; $n++ ) {

      $b = array_key_exists( $azPropertyNames[ $n ], $hObject );

      if ( $b ) {
        if ( ++$nPresent > $hSettings[ 'nMax' ] )
          throw new \Exception(
            $hSettings[ 'zLabel' ] . ': too many properties' );
        }
      else if ( $nCount === $hSettings[ 'nMin' ] )
        throw new \Exception( $hSettings[ 'zLabel' ] .
          ': missing property: ' . $azPropertyNames[ $n ] );

      } // $n

    if ( $nPresent < $hSettings[ 'nMin' ] )
      throw new \Exception(
        $hSettings[ 'zLabel' ] . ': too few properties' );

    } // fAssertProperties()

// EOF
