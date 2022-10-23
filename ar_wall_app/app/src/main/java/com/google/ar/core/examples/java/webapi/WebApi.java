package com.google.ar.core.examples.java.webapi;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;

import com.google.ar.core.examples.java.common.rendering.ImageBuffer;
import com.google.ar.core.examples.java.common.rendering.ImageTexture;
import com.google.gson.FieldNamingPolicy;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.io.BufferedInputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
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

    public Bitmap getImageFromURL(String uri) throws IOException {
        URL url = new URL(uri);
        HttpURLConnection connection = (HttpURLConnection) url.openConnection();
        Bitmap bitmap = BitmapFactory.decodeStream(new BufferedInputStream(connection.getInputStream()));
        return bitmap;
    }
}
