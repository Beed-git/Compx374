package com.google.ar.core.examples.java.webapi;

import android.util.JsonReader;

import com.google.gson.Gson;

import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;

import javax.net.ssl.HttpsURLConnection;

public class WebApi {
    static final String ApiWebURL = "https://tuakiri.trex-sandwich.com:443/";

    public void start(String accessToken) {
        try {
            URL url = new URL(ApiWebURL);
            HttpsURLConnection connection = (HttpsURLConnection)url.openConnection();

            connection.setRequestProperty("x-access-token", accessToken);

            if (connection.getResponseCode() == 200) {
                InputStream stream = connection.getInputStream();
                InputStreamReader reader = new InputStreamReader(stream);

                connection.disconnect();
            }

            else {
                throw new Exception("Response failed, error code: " + connection.getResponseCode());
            }
        } catch (Exception ex) {
            ex.printStackTrace();
        }
    }
}
