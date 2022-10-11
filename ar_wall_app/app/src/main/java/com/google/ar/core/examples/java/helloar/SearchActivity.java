package com.google.ar.core.examples.java.helloar;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;


public class SearchActivity extends AppCompatActivity{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        System.out.println(("Hi Brad"));
        setContentView(R.layout.activity_search);
    }
}
