package com.google.ar.core.examples.java.webapi;

import com.google.gson.FieldNamingPolicy;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;

import javax.net.ssl.HttpsURLConnection;

public class WebApi {
    private Gson gson;

    public WebApi() {
        this.gson = new GsonBuilder()
                .setFieldNamingPolicy(FieldNamingPolicy.LOWER_CASE_WITH_UNDERSCORES)
                .create();
    }

    public <T> T get(String uri, String accessToken, Class<T> tClass) throws Exception{
        URL url = new URL(uri);
        HttpsURLConnection connection = (HttpsURLConnection)url.openConnection();

        connection.setRequestProperty("x-access-token", accessToken);

        if (connection.getResponseCode() == 200) {
            InputStream stream = connection.getInputStream();
            InputStreamReader reader = new InputStreamReader(stream);

            T result = this.gson.fromJson(reader, tClass);
            connection.disconnect();
            return result;
        } else {
            throw new Exception("Response failed, error code: " + connection.getResponseCode());
        }
    }
}
