<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tbl_menu;
use App\Http\Resources\MenuTypesResource;

class MenuTypesController extends Controller {
    public function index( Request $request ) {
        $queryParams = json_decode( $request['queryParams'] );
        $paginate = 10;
        // dd( $queryParams->global_search );
        if ( $queryParams->per_page != 10 ) {
            $paginate = $queryParams->per_page;
        }
        $sort = ['name' => '', 'order' => ''];
        $sort = ( object )$sort;
        $sort->name = 'id';
        $sort->order = 'DESC';
        $sort->caseSensitive = true;
        $result = new Tbl_menu();
        $obj = array();

        if ( !empty( $queryParams->sort[0] ) ) {
            $sort = $queryParams->sort[0];

        }
        if ( isset( $queryParams->global_search ) && $queryParams->global_search != '' ) {
            $global_search = $queryParams->global_search;
            $result = $result->where( 'name', 'LIKE', '%'.$global_search.'%' );
        }

        $result = $result->orderBy( $sort->name, $sort->order )->paginate( $paginate );
        $data['data'] = $result;
        $data['total'] = $result->count();
        return $data;
    }

    public function store( Request $request ) {
        $data = $request->only( 'name', 'image' );
        if ( !empty( $data ) ) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move( public_path( 'images' ), $imageName );
            $data['image'] = $imageName;
            $result = Tbl_menu::create( $data );
            if ( isset( $result ) ) {
                return response()->json( 'Data Successully Store' );
            } else {
                return response()->json( 'Data is Not Store' );
            }
        } else {
            return response()->json( 'Data is Not Store' );
        }

    }

    public function update( Request $request ) {
        $id = $request->only( 'id' );
        $data = $request->only( 'name', 'image' );

        if ( !empty( $data ) ) {
            if ( !empty( $data['image'] ) ) {
                $data_check = Tbl_menu::where( 'id', $id )->first();
                if ( $data_check->image != NULL ) {
                    if ( $data_check->image != $data['image'] ) {
                        $image = $data_check->image;
                        $image_path = public_path( 'images/'.$image );
                        if ( file_exists( $image_path ) ) {
                            @unlink( $image_path );
                        }
                    }
                }
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move( public_path( 'images' ), $imageName );
                $data['image'] = $imageName;
                $result = Tbl_menu::where( 'id', $id )->update( $data );
                if ( isset( $result ) ) {
                    return response()->json( 'Data Successully Updated' );
                } else {
                    return response()->json( 'Data is Not Updated' );
                }
            } else {
                unset($data['image']);
                $result = Tbl_menu::where( 'id', $id )->update( $data );
                if(isset($result)){
                    return response()->json( 'Data Successully Updated' );
                }else{
                    return response()->json( 'Data is Not Updated' );
                }
            }
        }
    }

    public function edit( Request $request ) {
        $id = $request->id;

        $result = Tbl_menu::where( 'id', $id )->get();
        return $result;
    }

    public function delete( Request $request ) {
        $id = $request->id;

        $result = Tbl_menu::where( 'id', $id )->delete();
        if ( isset( $result ) ) {
            return response()->json( 'Data Deleted Successully' );
        } else {
            return response()->json( 'Data is Not Deleted' );
        }
    }

    public function muldelete( Request $request ) {
        $selected_items = $request->only( 'selected_items' );

        $result = array();
        foreach ( $selected_items as $key => $value ) {
            foreach ( $value as $id ) {
                $result[] = Tbl_menu::where( 'id', $id )->delete();
            }
        }
        if ( isset( $result ) ) {
            return response()->json( 'Data Deleted Successully' );
        } else {
            return response()->json( 'Data is Not Deleted' );
        }
    }

    public function changeimage( Request $request ) {
        $id = $request->only( 'id' );
        $data = $request->only( 'image' );
        if ( !empty( $data['image'] ) ) {
            $data_check = Tbl_menu::where( 'id', $id )->first();
            if ( $data_check->image != NULL ) {
                if ( $data_check->image != $data['image'] ) {
                    $image = $data_check->image;
                    $image_path = public_path( 'images/'.$image );
                    if ( file_exists( $image_path ) ) {
                        @unlink( $image_path );
                    }
                }
            }
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move( public_path( 'images' ), $imageName );
            $data['image'] = $imageName;
            $result = Tbl_menu::where( 'id', $id )->update( $data );
            if ( isset( $result ) ) {
                return response()->json( 'Data Successully Updated' );
            } else {
                return response()->json( 'Data is Not Updated' );
            }
        } else {
            return response()->json( 'Data is Not Updated' );
        }
    }

}
