<?php declare(strict_types=1);
//=============================================================================
//  Copyright 2022 Opplaud LLC and other contributors. MIT licensed.
//=============================================================================

use PHPUnit\Framework\TestCase;
use function Aponica\AssertProperties\fAssertProperties;

final class fAssertPropertiesTest extends TestCase {

  //---------------------------------------------------------------------------

  public function testAndWithOptionsPasses() : void {

    try {
      fAssertProperties(
        [ 'b' => true, 'n' => 123.456, 'z' => 'hello' ],
        [ 'b', 'n', 'z' ],
        [ 'zLabel' => 'and w/opts', 'bUseIn' => true ]
        );
      $this->assertTrue( true );
      }
    catch ( Exception ) {
      $this->assertFalse( 'should never happen' );
      }

    } // test(AndWithOptionsPasses)

  //---------------------------------------------------------------------------

  public function testAndWithOptionsThrows() : void {

    $this->expectException( Exception::class );
    $this->expectExceptionMessage( 'and w/opts: missing property: b' );

    fAssertProperties(
      [],
      [ 'b', 'n', 'z' ],
      [ 'zLabel' => 'and w/opts', 'bUseIn' => true ]
      );

    } // test(AndWithOptionsThrows)

  //---------------------------------------------------------------------------

  public function testAndWithoutOptionsPasses() : void {

    try {
      fAssertProperties(
        [ 'b' => true, 'n' => 123.456, 'z' => 'hello' ],
        [ 'b', 'n', 'z' ]
        );
      $this->assertTrue( true );
      }
    catch ( Exception ) {
      $this->assertFalse( 'should never happen' );
      }

    } // test(AndWithoutOptionsPasses)

  //---------------------------------------------------------------------------

  public function testAndWithoutOptionsThrows() : void {

    $this->expectException( Exception::class );
    $this->expectExceptionMessage( 'invalid hash: missing property: b' );

    fAssertProperties(
      [],
      [ 'b', 'n', 'z' ]
      );

    } // test(AndWithoutOptionsThrows)

  //---------------------------------------------------------------------------

  public function testOrWithMaxMinPasses() : void {

    try {
      fAssertProperties(
        [ 'b' => true, 'n' => 123.456, 'z' => 'hello' ],
        [ 'b', 'n', 'z' ],
        [ 'nMin' => 1, 'nMax' => 3 ]
        );
      $this->assertTrue( true );
      }
    catch ( Exception ) {
      $this->assertFalse( 'should never happen' );
      }

    } // test(OrWithMaxMinPasses)

  //---------------------------------------------------------------------------

  public function testOrWithMaxThrowsTooMany() : void {

    $this->expectException( Exception::class );
    $this->expectExceptionMessage( 'invalid hash: too many properties' );

    fAssertProperties(
      [ 'b' => true, 'n' => 123.456, 'z' => 'hello' ],
      [ 'b', 'n', 'z' ],
      [ 'nMax' => 2 ]
      );

    } // test(OrWithMinThrowsTooMany)

  //---------------------------------------------------------------------------

  public function testOrWithMinThrowsMissing() : void {

    $this->expectException( Exception::class );
    $this->expectExceptionMessage( 'invalid hash: missing property: n' );

    fAssertProperties(
      [ 'b' => true, 'z' => 'hello' ],
      [ 'b', 'n', 'z' ],
      [ 'nMin' => 3 ]
      );

    } // test(OrWithMinThrowsMissing)

  //---------------------------------------------------------------------------

  public function testOrWithMinThrowsTooFew() : void {

    $this->expectException( Exception::class );
    $this->expectExceptionMessage( 'invalid hash: too few properties' );

    fAssertProperties(
      [ 'b' => true, 'n' => 123.456, 'z' => 'hello' ],
      [ 'b', 'n', 'z' ],
      [ 'nMin' => 4 ]
      );

    } // test(OrWithMinThrowsTooFew)

} // fAssertPropertiesTest

// EOF
